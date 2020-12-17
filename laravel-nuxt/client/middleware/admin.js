export default ({ store, redirect }) => {
  if (!store.getters["auth/roles"].includes("admin")) {
    return redirect("/404");
  }
};
