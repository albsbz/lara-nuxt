import axios from "axios";

export { getAll, deleteItem, editItem, addItem };

async function getAll() {
  try {
    return (await axios.get("/dashboard/product-category/all")).data;
  } catch (e) {}
}
async function deleteItem(id) {
  try {
    return (
      await axios.delete("/dashboard/product-category/", {
        data: { id }
      })
    ).data;
  } catch (e) {}
}
async function editItem(form) {
  try {
    return (await form.post("dashboard/product-category/edit")).data;
  } catch (e) {}
}
async function addItem(form) {
  try {
    return (await form.post("dashboard/product-category/add")).data;
  } catch (e) {}
}
