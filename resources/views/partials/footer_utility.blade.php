{{-- Loader --}}
<div v-if="showLoader" class="wask_loader bg_half_transparent">
  <v-progress-circular :size="72" :width="4" color="primary" indeterminate></v-progress-circular>
</div>

{{-- Snackbar --}}
<v-snackbar :timeout="snackbarDuration" :color="snackbarColor" top v-model="showSnackbar">
  @{{ snackbarMessage }}
</v-snackbar>

{{-- Dialogs --}}
<v-dialog v-show="showDialog" v-model="showDialog" absolute max-width="450px">
  <v-card>
    <v-card-title>
      <div class="headline">
        <v-icon v-if="dialogIcon">@{{dialogIcon}}</v-icon> @{{ dialogTitle }}
      </div>
    </v-card-title>
    <v-card-text>@{{ dialogMessage }}</v-card-text>
    <v-card-actions v-if="dialogType=='confirm'">
      <v-spacer></v-spacer>
      <v-btn color="grey darken-1" text @click.native="dialogCancel">Cancel</v-btn>
      <v-btn color="primary darken-1" @click.native="dialogOk">Ok</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>

{{-- Progress Bar --}}
<v-progress-circular :size="72" :width="4" color="white" indeterminate></v-progress-circular>
