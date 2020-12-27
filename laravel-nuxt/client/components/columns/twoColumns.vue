<template>
  <v-row>
    <v-col cols="12" sm="3">
      <v-sheet rounded="lg" min-height="268">
        <slot name="col-1" />
      </v-sheet>
    </v-col>

    <v-col cols="12" sm="9">
      <v-sheet min-height="70vh" rounded="lg">
        <slot name="col-2" />
      </v-sheet>
    </v-col>
  </v-row>
</template>
