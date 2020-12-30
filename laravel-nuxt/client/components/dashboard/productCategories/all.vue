<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="allItems"
      sort-by="id"
      class="elevation-1"
    >
      <template #top>
        <v-toolbar flat>
          <v-toolbar-title>Product categories</v-toolbar-title>
          <v-spacer />
          <v-dialog v-model="dialog" max-width="500px">
            <v-card>
              <form @keydown="form.onKeydown($event)" @submit.prevent="save">
                <v-card-title>
                  Product categories
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <!-- Name -->
                    <v-row>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="form.name"
                          :error-messages="form.errors.errors.name"
                          :error="form.errors.has('name')"
                          :label="$t('name')"
                          name="name"
                        />
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="form.description"
                          :error-messages="form.errors.errors.description"
                          :error="form.errors.has('description')"
                          label="Description"
                          name="description"
                        />
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="form.slug"
                          :error-messages="form.errors.errors.slug"
                          :error="form.errors.has('slug')"
                          label="Slug"
                          name="slug"
                        />
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-select
                          v-model="form.parent_id"
                          item-value="id"
                          item-text="name"
                          :items="allItems"
                          label="Parent category"
                        />
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer />
                  <v-btn color="blue darken-1" text @click="close">
                    Cancel
                  </v-btn>
                  <v-btn color="blue darken-1" text type="submit">
                    Save
                  </v-btn>
                </v-card-actions>
              </form>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">
                Are you sure you want to delete this item?
              </v-card-title>
              <v-card-actions>
                <v-spacer />
                <v-btn color="blue darken-1" text @click="closeDelete">
                  Cancel
                </v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">
                  OK
                </v-btn>
                <v-spacer />
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template #item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon small @click="deleteItem(item)">
          mdi-delete
        </v-icon>
      </template>
      <template #no-data>
        <v-btn color="primary">
          Reset
        </v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import Form from "vform";
export default {
  props: ["allItems"],
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      { text: "ID", align: "start", value: "id" },
      { text: "Name", value: "name" },
      { text: "Parent", value: "parent.name" },
      { text: "Description", value: "description" },
      { text: "Slug", value: "slug" },
      { text: "Actions", value: "actions", sortable: false }
    ],

    editedIndex: -1,
    form: new Form({
      id: 0,
      parent_id: 1,
      name: "",
      description: "",
      slug: ""
    }),
    defaultItem: {
      id: 0,
      parent_id: 1,
      name: "",
      description: "",
      slug: ""
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    }
  },

  methods: {
    editItem(item) {
      this.editedIndex = this.allItems.indexOf(item);
      this.form = new Form(item);
      this.dialog = true;
    },

    deleteItem(item) {
      // this.editedIndex = this.allItems.indexOf(item);
      // this.editedItem = Object.assign({}, item);
      this.form = new Form(item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$emit("deleteItem", this.form.id);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        // this.editedItem = Object.assign({}, this.defaultItem);
        this.form = new Form(this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.form = new Form(this.defaultItem);
        this.editedIndex = -1;
      });
    },

    async save() {
      try {
        const { data } = await this.form.post(
          "dashboard/product-category/edit"
        );

        this.$emit("baseTab", data);
      } catch (e) {
        return;
      }
      this.close();
    }
  }
};
</script>
