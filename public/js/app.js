
import App from './components/App.js';
import DefaultLayout from './components/Layout.js';
import Header from './components/Header.js';

const app = new App();

app.renderComponent(app.rootElement, Header());
app.renderComponent(app.rootElement, DefaultLayout());

app.renderView();

/*
    Events
*/
window.addEventListener("click", (e) => {
    if(e && e.currentTarget)
        e.preventDefault();

        if(e.target.classList && e.target.classList.length)
        {

            if(e.target.classList.contains("edit")) 
            {
                if(e.target?.dataset?.id)
                {
                    app.editData = app.news.find((newsItem) => newsItem.id == e.target.dataset.id);
                    app.renderView(false);
                }
            }

            if(e.target.classList.contains("back-btn")) 
            {
                app.editData = null;
                app.renderView(false);
            }

            if(e.target.classList.contains("delete")) 
            {
                if(e.target?.dataset?.id)
                {
                    if(confirm("Are you sure you delete this news?"))
                    {
                        let token = localStorage.getItem("token");
                        fetch("/api/news", {
                            method: "DELETE",
                            body: JSON.stringify({id: e.target?.dataset?.id, token: token})
                        })
                        .then(
                            (resp) => resp.json()
                        )
                        .then((resp) => {
                            if(resp && !resp.error)
                            {
                                app.renderView();
                            }
                            else if(resp && resp.error)
                            {
                                app.renderMessage("error", resp.error);
                            }
                            else
                                console.error(resp);
                        })
                        .catch((resp)=>{
                            console.error(resp);
                        });
                    }
                }
            }
        }
        
    }
);

window.createNews = async (e) =>
{
    e.preventDefault();

    let loginForm = document.getElementById("editorForm");
    if(!loginForm) return;

    const formData = new FormData(loginForm);
    formData.append("token", localStorage.getItem("token"));
 
    fetch("/api/news", {
        method: "POST",
        body: formData
    })
    .then(
        (resp) => resp.json()
    )
    .then((resp) => {
        if(resp && resp.message)
        {
            app.renderMessage("success", resp.message);
        }
        else if(resp && resp.error)
        {
            app.renderMessage("error", resp.error);
        }

        if(resp && !resp.error)
        {
            app.renderView();
        }
        else
            console.error(resp);
    })
    .catch((resp)=>{
        console.error(resp);
    });
}

window.updateNews = async (e) =>
{
    e.preventDefault();

    let loginForm = document.getElementById("editorForm");
    if(!loginForm) return;

    const formData = new FormData(loginForm);
    formData.append("token", localStorage.getItem("token"));
    const jsonData = JSON.stringify(Object.fromEntries(formData));
 
    fetch("/api/news", {
        method: "PUT",
        body: jsonData,
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(
        (resp) => resp.json()
    )
    .then((resp) => {
        if(resp && resp.message)
        {
            app.renderMessage("success", resp.message);
        }
        else if(resp && resp.error)
        {
            app.renderMessage("error", resp.error);
        }

        if(resp && !resp.error)
        {
            app.renderView();
        }
        else
            console.error(resp);
    })
    .catch((resp)=>{
        console.error(resp);
    });
}

window.login = async (e) =>
{
    e.preventDefault();

    let loginForm = document.getElementById("loginForm");
    if(!loginForm) return;

    const formData = new FormData(loginForm);
 
    fetch("/api/login", {
        method: "POST",
        body: formData
    })
    .then(
        (resp) => resp.json()
    )
    .then((resp) => {
        if(resp && resp.message)
        {
            app.renderMessage("success", resp.message);
        }
        else if(resp && resp.error)
        {
            app.renderMessage("error", resp.error);
        }

        if(resp && resp.token)
        {
            /* Save token */
            localStorage.setItem("token", resp.token);
            app.renderView();
        }
        else
            console.error(resp);
    })
    .catch((resp)=>{
        console.error(resp);
    });
}

window.logout = async (e) =>
{
    e.preventDefault();

    const token = localStorage.getItem("token");
    if(token != null)
    {
        fetch("/api/logout", {
            method: "POST",
            body: JSON.stringify({token:token})
        })
        .then((resp) => {
            if(resp && (resp.status == 200 || resp.status == 401))
            {
                /* Save token */
                localStorage.removeItem("token");
                app.renderView();
            }
            else
                console.error(resp);
        })
        .catch((resp)=>{
            console.error(resp);
        });
    }
}