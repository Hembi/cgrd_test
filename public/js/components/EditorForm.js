const EditorForm = function(data = null)
{
    let id = (data && data.id) ? data.id : "";
    let title = (data && data.title) ? data.title : "";
    let description = (data && data.description) ? data.description : "";

    let heading = id ? "Edit News" : "Create News";

    return `
        <div class="editor-wrapper">
            <form id="editorForm">
                <div class="heading-wrapper">
                    <h3>${heading}</h3>
                    <div class="buttons-wrapper" ${id ? '': 'hidden'}>
                        <img src="/public/images/close.svg" class="back-btn">
                    </div>
                </div>
                <input name="id" type="hidden" value="${id}"/>
                <div class="input-wrapper">
                    <input name="title" type="text" placeholder="Title" value="${title}"/>
                </div>
                <div class="input-wrapper">
                    <textarea name="description" type="text" placeholder="Description">${description}</textarea>
                </div>
                <button class="btn" onClick="createNews(event)" ${id ? 'hidden': ''}>Create</button>
                <button class="btn" onClick="updateNews(event)" ${id ? '': 'hidden'}>Save</button>
                <button class="btn" onClick="logout(event)">Logout</button>
            </form>
        </div>
    `;
}
export default EditorForm