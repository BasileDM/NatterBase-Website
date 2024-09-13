import globals from 'globals';
import pluginJs from '@eslint/js';
import tseslint from '@typescript-eslint/eslint-plugin';
import tsParser from '@typescript-eslint/parser';

export default [
  {
    // Apply these settings to JavaScript and TypeScript files
    files: ['**/*.{js,mjs,cjs,ts}'],

    // Set language options for both JS and TS
    languageOptions: {
      parser: tsParser,
      globals: globals.browser,
      ecmaVersion: 2021,
      sourceType: 'module',
    },

    // Extend from recommended configurations for JavaScript and TypeScript
    plugins: {
      '@typescript-eslint': tseslint,
    },

    // JavaScript recommended config
    rules: {
      ...pluginJs.configs.recommended.rules,

      // TypeScript recommended rules
      ...tseslint.configs.recommended.rules,

      // Custom rules for your project
      'indent': ['error', 2],
      'quotes': ['error', 'single'],
      'semi': ['error', 'always'],
      'no-unused-vars': 'warn',
      '@typescript-eslint/no-unused-vars': 'warn',
      'arrow-spacing': ['warn', { before: true, after: true }],
      'brace-style': ['error', 'stroustrup', { allowSingleLine: true }],
      'comma-dangle': ['error', 'always-multiline'],
      'comma-spacing': 'error',
      'comma-style': 'error',
      curly: ['error', 'multi-line', 'consistent'],
      'dot-location': ['error', 'property'],
      'handle-callback-err': 'off',
      'keyword-spacing': 'error',
      'max-nested-callbacks': ['error', { max: 4 }],
      'max-statements-per-line': ['error', { max: 2 }],
      'no-console': 'off',
      'no-empty-function': 'error',
      'no-floating-decimal': 'error',
      'no-inline-comments': 'error',
      'no-lonely-if': 'error',
      'no-multi-spaces': 'error',
      'no-multiple-empty-lines': ['error', { max: 2, maxEOF: 1, maxBOF: 0 }],
      'no-shadow': ['error', { allow: ['err', 'resolve', 'reject'] }],
      'no-trailing-spaces': 'error',
      'no-var': 'error',
      'object-curly-spacing': ['error', 'always'],
      'prefer-const': 'error',
      'space-before-blocks': 'error',
      'space-before-function-paren': [
        'error',
        {
          anonymous: 'never',
          named: 'never',
          asyncArrow: 'always',
        },
      ],
      'space-in-parens': 'error',
      'space-infix-ops': 'error',
      'space-unary-ops': 'error',
      'spaced-comment': 'error',
      yoda: 'error',
    },
  },
];
