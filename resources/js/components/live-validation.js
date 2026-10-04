// Live client-side validation driven entirely by native HTML constraints
// (required, pattern, minlength, type=email, ...), so each field's rule is
// declared once on the field itself.
//
// - Adds a red asterisk to the label of every required field.
// - Validates a field once the user leaves it, then re-validates as they type.
// - On submit, flags every invalid field and scrolls to the first one.
//
// Usage: <form x-data="liveValidation"> ... </form>
// Optional per-field message: data-error="Contact number must be 11 digits."

const FIELDS = 'input:not([type=hidden]):not([readonly]), select, textarea';

const ERROR_CLASS = {
    select: 'select-error',
    textarea: 'textarea-error',
    file: 'file-input-error',
    default: 'input-error',
};

export default () => ({
    init() {
        const form = this.$el;

        // We render our own messages; keep the browser's bubbles out of the way.
        form.setAttribute('novalidate', '');

        form.querySelectorAll(FIELDS).forEach((field) => {
            if (field.required) this.markRequired(field);
        });

        form.addEventListener('focusout', (e) => {
            if (!e.target.matches(FIELDS)) return;
            e.target.dataset.touched = 'true';
            this.validate(e.target);
        });

        const revalidate = (e) => {
            if (e.target.matches(FIELDS) && e.target.dataset.touched) this.validate(e.target);
        };
        form.addEventListener('input', revalidate);
        form.addEventListener('change', revalidate);

        form.addEventListener('submit', (e) => {
            const fields = [...form.querySelectorAll(FIELDS)];
            fields.forEach((field) => {
                field.dataset.touched = 'true';
                this.validate(field);
            });

            const firstInvalid = fields.find((field) => !field.checkValidity());
            if (firstInvalid) {
                e.preventDefault();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus({ preventScroll: true });
            }
        });
    },

    markRequired(field) {
        const labelText = field.closest('.form-control')?.querySelector('.label .label-text');
        if (!labelText || labelText.querySelector('[data-required-mark]')) return;

        const mark = document.createElement('span');
        mark.className = 'ml-0.5 text-error';
        mark.dataset.requiredMark = '';
        mark.textContent = '*';
        labelText.appendChild(mark);
    },

    validate(field) {
        const valid = field.checkValidity();
        const errorClass = ERROR_CLASS[field.type] ?? ERROR_CLASS[field.tagName.toLowerCase()] ?? ERROR_CLASS.default;
        field.classList.toggle(errorClass, !valid);
        field.setAttribute('aria-invalid', String(!valid));

        const container = field.closest('.form-control');
        if (!container) return;

        let message = container.querySelector('[data-live-error]');
        if (valid) {
            message?.remove();
            return;
        }

        if (!message) {
            message = document.createElement('label');
            message.className = 'label';
            message.dataset.liveError = '';
            message.innerHTML = '<span class="text-error label-text-alt"></span>';
            container.appendChild(message);
        }
        message.firstElementChild.textContent = this.messageFor(field);
    },

    messageFor(field) {
        const { validity } = field;
        if (validity.valueMissing) return 'This field is required.';
        return field.dataset.error || field.validationMessage;
    },
});
