import axios from "axios";

export { getAll, deleteItem, editItem, addItem };

async function getAll() {
  try {
    return (await axios.get("/dashboard/roles/all")).data;
  } catch (e) {}
}
async function deleteItem(id) {
  try {
    return (
      await axios.delete("/dashboard/user/", {
        data: { id }
      })
    ).data;
  } catch (e) {}
}
async function editItem(form) {
  try {
    return (await form.post("dashboard/user/edit")).data;
  } catch (e) {}
}
async function addItem(form) {
  try {
    return (await await form.post("dashboard/user/add")).data;
  } catch (e) {}
}
