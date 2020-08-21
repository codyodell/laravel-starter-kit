let Readable = {
    data: () => ({
        page_title: "",
        page_subtitle: "",
        page_icon: ""
    }),
    computed: {
        slug() {
            return this.page_title ? _.kebabCase(this.page_title) : null;
        }
    }
};
export default Readable;
