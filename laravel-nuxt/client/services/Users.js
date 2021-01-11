import axios from "axios";

export { getAll, deleteItem, editItem };

async function getAll() {
  try {
    return (await axios.get("/dashboard/user/all")).data;
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
