<div>
  <v-breadcrumbs :items="getBreadcrumbs">
    <template v-slot:item="props">
      <v-breadcrumbs-item :to="props.item.to" exact :key="props.item.label" :disabled="props.item.disabled">
        <template v-slot:divider>
          <v-icon>mdi-circle-medium</v-icon>
        </template>
        @{{ props.item.label }}
      </v-breadcrumbs-item>
    </template>
  </v-breadcrumbs>
</div>
