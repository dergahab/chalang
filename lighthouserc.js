module.exports = {
    ci: {
        collect: {
            startServerCommand: 'npm run build && php artisan serve --port=4173',
            url: [
                'http://localhost:4173/react-test?lang=az',
                'http://localhost:4173/react-test?lang=en',
                'http://localhost:4173/react-test?lang=ru',
            ],
            numberOfRuns: 3,
            settings: {
                preset: 'desktop',
                formFactor: 'desktop',
                screenEmulation: {
                    width: 1440,
                    height: 900,
                },
            },
        },
        assert: {
            assertions: {
                'categories:performance': ['warn', { minScore: 0.8 }],
                'categories:accessibility': ['error', { minScore: 0.9 }],
                'categories:best-practices': ['error', { minScore: 0.9 }],
                'categories:seo': ['error', { minScore: 0.9 }],
                'first-contentful-paint': ['warn', { maxNumericValue: 2500 }],
                'interactive': ['warn', { maxNumericValue: 5000 }],
            },
        },
        upload: {
            target: 'temporary-public-storage',
        },
    },
};
