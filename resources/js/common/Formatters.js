export default {
    install(Vue, options) {
        Vue.prototype.$appFormatters = {
            formatDate: function(value, format) {
                if (!value) return false;
                let m = moment(value);
                if (!m.isValid()) return false;
                return m.format(format || "MM/DD/YYYY");
            },
            formatByteToMB(sizeInBytes) {
                return (sizeInBytes / (1024 * 1024)).toFixed(2);
            },
            formatMbToBytes(mb) {
                return (mb * 1048576).toFixed(2);
            },
            slug(strSlug) {
                return _.kebabCase(strSlug);
            }
        };
    }
};
