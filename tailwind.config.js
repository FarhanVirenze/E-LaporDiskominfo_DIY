import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    safelist: [
        "bg-blue-100",
        "text-blue-800",
        "bg-blue-900",
        "text-blue-300",
        "bg-green-100",
        "text-green-800",
        "bg-green-900",
        "text-green-300",
    ],
    theme: {
        extend: {
            spacing: {
        '25': '6.25rem', // 25 x 0.25rem = 6.25rem
        '26': '6.5rem',  // 26 x 0.25rem = 6.5rem
      },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms],
    extend: {
        utilities: {
            "will-change-transform": {
                willChange: "transform",
            },
            "backface-hidden": {
                backfaceVisibility: "hidden",
            },
        },
    },
    animation: {
        "spin-slow": "spin 2s linear infinite",
        "fade-in": "fadeIn 0.8s ease-in-out forwards",
    },
    keyframes: {
        fadeIn: {
            "0%": { opacity: 0 },
            "100%": { opacity: 1 },
        },
    },
};
