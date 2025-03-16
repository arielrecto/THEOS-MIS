import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#D0E7FF", // Light Blue Background
                    secondary: "#6C9BCF", // Medium Blue Accent
                    accent: "#3B82F6", // Strong Blue for CTA
                    neutral: "#1E3A8A", // Dark Blue for Text and Headers
                    "base-100": "#FFFFFF", // White Background for Cards and Sections
                    info: "#93C5FD", // Soft Blue for Info Elements
                    success: "#34D399", // Green for Success Messages
                    warning: "#FBBF24", // Yellow for Warnings
                    error: "#EF4444", // Red for Errors
                },
            },
        ],
    },

    plugins: [forms, require("daisyui")],
};
