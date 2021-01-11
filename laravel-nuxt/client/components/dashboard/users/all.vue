<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="allItems"
      sort-by="id"
      class="elevation-1"
    >
      <template #item.roles="{ item }">
        <div v-if="item.roles" class="p-2">
          <p>{{ roleToShow(item) }}</p>
        </div>
      </template>

      <template #top>
        <v-toolbar flat>
          <v-toolbar-title>Users</v-toolbar-title>
          <v-spacer />
          <v-dialog v-model="dialog" max-width="800px">
            <v-card>
              <form
                id="save"
                @keydown="form.onKeydown($event)"
                @submit.prevent="save"
              />
              <v-card-title>
                Users
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field
                        v-model="form.name"
                        :error-messages="form.errors.errors.name"
                        :error="form.errors.has('name')"
                        :label="$t('name')"
                        name="name"
                      />
                      <v-text-field
                        v-model="form.email"
                        :error-messages="form.errors.errors.email"
                        :error="form.errors.has('email')"
                        :label="$t('email')"
                        name="email"
                      />
                      <v-text-field
                        v-model="form.phone"
                        :error-messages="form.errors.errors.phone"
                        :error="form.errors.has('phone')"
                        :label="$t('phone')"
                        name="phone"
                      />
                      <v-text-field
                        v-model="form.address"
                        :error-messages="form.errors.errors.address"
                        :error="form.errors.has('address')"
                        :label="$t('address')"
                        name="address"
                      />
                      <v-select
                        v-model="form.roles"
                        item-text="name"
                        item-value="id"
                        :items="allRoles"
                        label="Roles"
                        :error-messages="form.errors.errors.roles"
                        :error="form.errors.has('roles')"
                        attach
                        chips
                        multiple
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
                <v-btn color="blue darken-1" text type="submit" form="save">
                  Save
                </v-btn>
              </v-card-actions>
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
import * as service from "~/services/Users";
import * as roles from "~/services/Roles";

export default {
  props: ["allItems"],
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      { text: "ID", align: "start", value: "id" },
      { text: "Name", value: "name" },
      { text: "Email", value: "email" },
      { text: "Address", value: "address" },
      { text: "Phone", value: "phone" },
      { text: "Roles", value: "roles" },
      { text: "Actions", value: "actions", sortable: false }
    ],
    editedIndex: -1,
    form: new Form({
      name: "",
      email: "",
      address: "",
      phone: "",
      roles: []
    }),
    defaultItem: {
      name: "",
      email: "",
      address: "",
      phone: "",
      roles: []
    },
    allRoles: [],
    overlay: false
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
  created() {
    this.initialize();
  },

  methods: {
    roleToShow(item) {
      return item.roles.reduce((res, role) => {
        return `${role.name}, ${res}`;
      }, "");
    },
    async initialize() {
      this.allRoles = await roles.getAll();
    },

    async editItem(item) {
      await this.initialize();

      this.editedIndex = this.allItems.indexOf(item);
      this.form = new Form(item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.form.id = item.id;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$emit("deleteItem", this.form.id);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
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
      this.form.roles = this.form.roles.map(role =>
        role?.id ? role.id : role
      );
      const data = await service.editItem(this.form);
      if (data) {
        this.$emit("baseTab", data);
        this.close();
      }

      // parent:
      // if(data.error) { handle error response }
    }
  }
};
</script>
