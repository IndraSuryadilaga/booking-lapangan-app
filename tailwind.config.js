import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

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
                    100: '#edf0fe',
                    200: '#c4d1fc',
                    300: '#8aa9f9',
                    400: '#3B82F6',
                    500: '#1e5fbd',
                    600: '#113e80',
                    700: '#052048',
                },
                accent: {
                    100: '#beffde',
                    200: '#17e5a0',
                    300: '#10B981',
                    400: '#0a8f63',
                    500: '#056746',
                    600: '#02422b',
                    700: '#012013',
                },
                neutral: {
                    100: '#e3e5e9',
                    200: '#b8bdc8',
                    300: '#8e97a8',
                    400: '#6B7280',
                    500: '#4a4f59',
                    600: '#2c2f36',
                    700: '#0f1114',
                },
                danger: {
                    100: '#fcdede',
                    200: '#f8a8a8',
                    300: '#f56969',
                    400: '#DC2626',
                    500: '#9d1818',
                    600: '#620b0b',
                    700: '#2b0202',
                },
                warning: {
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706',
                    700: '#b45309',
                },
                success: {
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                },
                status: {
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
            fontSize: {
                'xs': ['0.75rem', { lineHeight: '1.125rem', letterSpacing: '0.01em' }],    // 12px
                'sm': ['0.875rem', { lineHeight: '1.25rem', letterSpacing: '0.01em' }],    // 14px
                'base': ['1rem', { lineHeight: '1.5rem', letterSpacing: '0' }],             // 16px
                'lg': ['1.125rem', { lineHeight: '1.75rem', letterSpacing: '-0.01em' }],   // 18px
                '2xl': ['1.375rem', { lineHeight: '1.75rem', letterSpacing: '-0.015em' }], // 22px
                '3xl': ['1.75rem', { lineHeight: '2.25rem', letterSpacing: '-0.02em' }],   // 28px
                '4xl': ['2.25rem', { lineHeight: '2.75rem', letterSpacing: '-0.025em' }],  // 36px
            },
            borderRadius: {
                'xl': '12px',
                '2xl': '16px',
            },
            boxShadow: {
                'sm': '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                'md': '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
            },
        },
    },
    plugins: [
        forms,
        function ({ addBase }) {
            addBase({
                'button:focus, [type="button"]:focus, [type="reset"]:focus, [type="submit"]:focus': {
                    outline: 'none',
                    'box-shadow': 'none',
                },
                'button:focus-visible, [type="button"]:focus-visible': {
                    outline: '2px solid currentColor',
                    'outline-offset': '2px',
                },
            });
        },
        require('tailwind-scrollbar-hide')
    ],
};
