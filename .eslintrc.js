module.exports = {
    root: true,
    env: {
        node: true,
        browser: true,
        commonjs: true,
        es6: true
    },
    extends: [
        "plugin:vue/recommended",
        "plugin:prettier/recommended",
        "eslint:recommended"
    ],
    parserOptions: {
        parser: "babel-eslint",
        ecmaVersion: 2017,
        sourceType: "module"
    },
    plugins: ["vue"],
    rules: {
        "no-debugger": process.env.NODE_ENV === "production" ? "error" : "off"
    }
};
