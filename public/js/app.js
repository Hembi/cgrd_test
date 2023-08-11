
class App
{
    constructor()
    {
        const rootElement = document.getElementById("app");
        if(typeof rootElement !== 'undefined')
            rootElement.innerHTML = "<h1>JS FrontEnd</h1>";
    }
}
new App();