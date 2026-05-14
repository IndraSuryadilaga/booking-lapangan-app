import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        ],

    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    900: '#1e3a8a',
                },
                accent: {
                    400: '#34d399',
                    500: '#10b981',
                    600: '#059669',
                },
                status: {
                    success: '#16a34a',
                    warning: '#d97706',
                    danger: '#dc2626',
                    info: '#0284c7',
                    muted: '#9ca3af',
                    expired: '#6b7280',
                }
            },
            spacing: {
                'space-1': '4px',
                'space-2': '8px',
                'space-3': '12px',
                'space-4': '16px',
                'space-6': '24px',
                'space-8': '32px',
                'space-12': '48px',
                'space-16': '64px',
            },
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui'],
            },
            borderRadius: {
                'xl': '12px',
                '2xl': '16px',
            }
        },
    },
    plugins: [forms],
};
