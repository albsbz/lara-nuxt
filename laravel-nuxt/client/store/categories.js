import axios from "axios";

// state
export const state = () => ({
  categories: null
});

// getters
export const getters = {
  categories: state => state.categories
};

// mutations
export const mutations = {
  SET_CATEGORIES(state, categories) {
    state.categories = categories;
  }
};

// actions
export const actions = {
  async fetchCategories({ commit }) {
    try {
      const { data } = await axios.get("/categories/all");
      commit("SET_CATEGORIES", data);
    } catch (e) {}
  }
};
