import axios from "axios";

export { getAll, deleteItem, editItem, addItem };

async function getAll() {
  try {
    return (await axios.get("/dashboard/product/all")).data;
  } catch (e) {}
}
async function deleteItem(id) {
  try {
    return (
      await axios.delete("/dashboard/product/", {
        data: { id }
      })
    ).data;
  } catch (e) {}
}
async function editItem(form) {
  try {
    return (await form.post("dashboard/product/edit")).data;
  } catch (e) {}
}
async function addItem(form) {
  try {
    return (await form.post("dashboard/product/add")).data;
  } catch (e) {}
}
