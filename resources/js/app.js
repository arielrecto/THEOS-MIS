import Alpine from "alpinejs";
import axios from "axios";
import gallery from './components/gallery';

window.Alpine = Alpine;

// Register gallery component
Alpine.data('gallery', gallery);

Alpine.data("imageHandler", () => ({
    imageSrc: null,
    uploadHandler(e) {
        const { files } = e.target;

        const reader = new FileReader();

        reader.onload = function () {
            this.imageSrc = reader.result;
        }.bind(this);

        reader.readAsDataURL(files[0]);
    },
}));

Alpine.data("lineChart", () => ({
    chart: null,
    init() {
        const chartElement = this.$refs.chart;

        var options = {
            series: [
                {
                    name: "Desktops",
                    data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
                },
            ],
            chart: {
                height: 350,
                type: "line",
                zoom: {
                    enabled: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "straight",
            },
            title: {
                text: "Product Trends by Month",
                align: "left",
            },
            grid: {
                row: {
                    colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                    opacity: 0.5,
                },
            },
            xaxis: {
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                ],
            },
        };

        this.chart = new ApexCharts(chartElement, options);
        this.chart.render();
    },
}));

Alpine.data("calendarInit", () => ({
    calender: null,
    init() {
        const calendarElement = this.$refs.calendar;

        var calendar = new FullCalendar.Calendar(calendarElement, {
            initialView: "dayGridMonth",
        });
        calendar.render();
    },
}));

Alpine.data("studentSelection", () => ({
    students: [],
    selectedStudents: [],
    initStudentData(data) {
        this.students = [...data];
    },
    selectStudent(data) {
        this.selectedStudents = [data, ...this.selectedStudents];
    },
    checkStudentExists(c_student) {
        return this.selectedStudents.some((u) => u.id === c_student.id);
    },
    removeStudent(c_student) {
        this.selectedStudents = [
            ...this.selectedStudents.filter((item) => item.id !== c_student.id),
        ];
    },
    selectAllStudent() {
        if (this.selectedStudents.length !== 0) {
            this.selectedStudents = [];
        }

        this.selectedStudents = [...this.students];
    },
}));

Alpine.data("attachmentUpload", () => ({
    files: [],
    fileBluePrint: {
        localId: 0,
        data: null,
        type: null,
        extension: null,
    },
    url: null,
    fileData: null,
    fileType: null,
    toggle: false,
    init() {},
    toggleAction() {
        this.toggle = !this.toggle;
    },
    selectFileType(type) {
        this.fileType = type;
    },
    addFileLink() {
        this.fileBluePrint.localId += 1;

        const data = {
            localId: this.fileBluePrint.localId,
            data: this.url,
            type: this.fileType,
        };

        this.files = [data, ...this.files];

        this.url = null;

        console.log("====================================");
        console.log(this.files);
        console.log("====================================");
        this.fileType = null;
        this.toggle = false;
    },
    removeFile(localId) {
        this.files = [...this.files.filter((file) => file.localId !== localId)];
    },
    fileUploadHandler(e) {
        const { files } = e.target;

        const reader = new FileReader();

        reader.onload = function () {
            this.fileData = {
                name: files[0].name,
                data: reader.result,
                type: files[0].name.split(".").pop(),
            };
        }.bind(this);

        reader.readAsDataURL(files[0]);
    },
    addFileData() {
        this.fileBluePrint.localId += 1;
        const data = {
            ...this.fileBluePrint,
            localId: (this.fileBluePrint.localId += 1),
            data: this.fileData.data,
            name: this.fileData.name,
            extension: this.fileData.type,
            type: this.fileType,
        };

        this.files = [...this.files, data];

        this.toggle = false;
        this.fileData = null;
    },
}));

Alpine.data("generateThumbnail", () => ({
    thumbnails: {
        pdf: "https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg",
        mp4: "https://upload.wikimedia.org/wikipedia/commons/4/4e/Video-icon.svg",
        docx: "https://s2.svgbox.net/files.svg?ic=word2", // DOC
        xls: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-excel", // XLS
        ppt: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-powerpoint", // PPT
        txt: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-alt", // TXT
        jpg: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-image", // JPG
        png: "https://s2.svgbox.net/files.svg?ic=image", // PNG
        gif: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-image", // GIF
        zip: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-archive", // ZIP
        html: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-code", // HTML
        css: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-code", // CSS
        js: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=file-code", // JavaScript
        php: "https://s2.svgbox.net/hero-solid.svg?color=000&ic/file-code", // PHP
        url: "https://s2.svgbox.net/hero-solid.svg?color=000&ic=link",
    },
    getThumbnail(extension) {
        console.log("====================================");
        console.log(extension);
        console.log("====================================");
        return (
            this.thumbnails[extension] || "https://example.com/default_icon.svg"
        );
    },
}));

Alpine.data("QrScanner", () => ({
    result: null,
    scanner: null,
    height: 250,
    width: 250,
    type: null,
    students: [],
    errors : {

    },
    init() {
        const reader = this.$refs.reader;

        if (typeof Html5QrcodeScanner === "undefined") {
            setTimeout(() => this.init(), 100);
            return;
        }

        this.scanner = new Html5QrcodeScanner(reader.id, {
            fps: 10,
            qrbox: {
                width: this.width,
                height: this.height,
            },
        });

        this.scanner.render(this.onSuccess.bind(this), this.onError);

        this.$watch("result", () => {
            const data = this.result.split("-");

            console.log(data);

            const formData = new FormData();
            formData.append("student", data[1]);
            formData.append("attendanceCode", data[0]);
            formData.append("classroom", data[2]);



            if(this.type) {
                this.submitAttendanceStudent(formData);
                return;
            };

            this.submitAttendance(formData);
        });
    },
    studentInit(data) {
        this.students = [...data];
    },
    onSuccess(decodedText, decodedResult) {
        if (this.result !== null && this.result === decodedText) return;

        this.result = decodedText;
    },

    async submitAttendance(payload) {
        try {
            console.log(payload, "hile");
            const response = await axios.post(
                "/teacher/classrooms/attendances/student",
                payload
            );

            console.log("hi");

            this.students = [...this.students, response.student];

            alert("attendance successs");
        } catch (error) {
            console.log(error);
        }
    },

    async submitAttendanceStudent(payload) {
        try {

            console.log(payload);
            console.log(payload, "hile");
            const response = await axios.post(
                "/student/attendances/log",
                payload
            );

            console.log("hi");

            this.students = [...this.students, response.student];

            alert("attendance successs");
        } catch (error) {
            console.log(error);
            this.errors = {
                ...error.response.data
            }
        }
    },
}));

Alpine.start();
