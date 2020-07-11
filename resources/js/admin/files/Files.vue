<template>
  <div class="page_wrap_vue">
    <v-tabs color="primary" v-model="active">
      <v-tab key="files" href="#files" ripple>Files</v-tab>
      <v-tab key="manage-groups" href="#manage-groups" ripple>Manage File Groups</v-tab>
      <v-tab key="upload" href="#upload" ripple>Upload</v-tab>
      <v-tab-item value="files">
        <v-container>
          <file-lists></file-lists>
        </v-container>
      </v-tab-item>
      <v-tab-item value="manage-groups">
        <v-container>
          <file-group-lists></file-group-lists>
        </v-container>
      </v-tab-item>
      <v-tab-item value="upload">
        <v-container>
          <file-upload></file-upload>
        </v-container>
      </v-tab-item>
    </v-tabs>
  </div>
</template>

<script>
import FileUpload from "./components/FileUpload.vue";
import FileGroupLists from "./components/FileGroupLists.vue";
import FileLists from "./components/FileLists.vue";

export default {
  components: {
    FileUpload,
    FileGroupLists,
    FileLists
  },
  mounted() {
    console.info("pages.FileManager.vue");
    const self = this;
    self.update_breadcrumbs("Files", "files");
  },
  data() {
    return {
      active: "files"
    };
  },
  watch: {
    active(v) {
      const self = this;
      self.update_breadcrumbs(v, v.split("-").join(" "));
    }
  },
  methods: {
    update_breadcrumbs: function(strLabel, strName) {
      if (strName || strLabel) {
        this.$store.commit("setBreadcrumbs", [
          { label: strLabel, name: strName }
        ]);
      }
    }
  }
};
</script>

<style scoped>
.finder_wrap {
  padding: 0 1.25em;
}
</style>
