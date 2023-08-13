
import LoginForm from '../components/LoginForm.js';
import NewsList from '../components/NewsList.js';
import Message from '../components/Message.js';
import EditorForm from '../components/EditorForm.js';
class App
{
    rootElement;
    news = [];
    editData = null;

    constructor()
    {
        this.rootElement = document.getElementById("app");
    }

    renderComponent(element, html, position = 'beforeend')
    {
        if(typeof element !== 'undefined')
        {
            element.insertAdjacentHTML(position, html);
        }
    }

    async renderView(refresh = true)
    {
        const mainElement = document.getElementById("content");
        if(mainElement)
        {
            const token = localStorage.getItem("token");
            if(token != null)
            {
                mainElement.innerHTML = "";
                if(refresh)
                {
                    this.editData = null;
                    await this.getNewsData(token);
                }
                if(this.news.length)
                    this.renderComponent(mainElement, NewsList(this.news), 'afterbegin');
                this.renderComponent(mainElement, EditorForm(this.editData));
            }
            else
            {
                mainElement.innerHTML = "";
                this.renderComponent(mainElement, LoginForm());
            }
        }
    }
    
    renderMessage($type, $message)
    {
        const messageElement = document.getElementById("messageWrapper");
        if(messageElement)
        {
            messageElement.innerHTML = "";
            if($type && $message)
                this.renderComponent(messageElement, Message($type, $message));
        }
    }

    resetMessageWrapper()
    {
        const messageElement = document.getElementById("messageWrapper");
        if(messageElement)
        {
            messageElement.innerHTML = "";
        }
    }

    async getNewsData(token)
    {
        await new Promise((resolve, reject) => {
            fetch("/api/news?token="+token)
            .then(
                (resp) => {
                    if(resp && resp.status == 401)
                    {
                        localStorage.removeItem("token");
                        this.renderView();
                        reject(false);
                    }
                    else 
                        return resp.json();
                }
            )
            .then((resp) => {
                if(resp)
                {
                    this.news = resp;
                }
                resolve(true);
            })
            .catch((resp)=>{console.error(resp); reject(false);});
        });
    }
}
export default App