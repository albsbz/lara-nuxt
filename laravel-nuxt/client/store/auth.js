import axios from "axios";
import Cookies from "js-cookie";

// state
export const state = () => ({
  user: null,
  roles: ["guest"],
  token: null
});

// getters
export const getters = {
  user: state => state.user,
  roles: state => state.roles,
  token: state => state.token,
  check: state => state.user !== null
};

// mutations
export const mutations = {
  SET_TOKEN(state, token) {
    state.token = token;
  },
  SET_ROLE(state, roles) {
    state.roles = roles;
  },

  FETCH_USER_SUCCESS(state, user) {
    state.user = user;
  },

  FETCH_USER_FAILURE(state) {
    state.token = null;
  },

  LOGOUT(state) {
    state.user = null;
    state.token = null;
  },

  UPDATE_USER(state, { user }) {
    state.user = user;
  }
};

// actions
export const actions = {
  saveToken({ commit, dispatch }, { token, remember }) {
    commit("SET_TOKEN", token);

    Cookies.set("token", token, { expires: remember ? 365 : null });
  },

  async fetchUser({ commit }) {
    try {
      const { data } = await axios.get("/user");
      const roles = await axios.get("/role");

      commit(
        "SET_ROLE",
        roles.data.map(el => el.name)
      );
      commit("FETCH_USER_SUCCESS", data);
    } catch (e) {
      Cookies.remove("token");

      commit("SET_ROLE", ["guest"]);
      commit("FETCH_USER_FAILURE");
    }
  },

  updateUser({ commit }, payload) {
    commit("UPDATE_USER", payload);
  },

  async logout({ commit }) {
    try {
      await axios.post("/logout");
    } catch (e) {}

    Cookies.remove("token");

    commit("LOGOUT");
    commit("SET_ROLE", ["guest"]);
  },

  async fetchOauthUrl(ctx, { provider }) {
    const { data } = await axios.post(`/oauth/${provider}`);

    return data.url;
  }
};
