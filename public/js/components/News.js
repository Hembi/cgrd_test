const News = function(news)
{
    return `
        <div class="news-wrapper">
            <div class="title">${news.title}</div>
            <div class="description">${news.description}</div>
            
            <div class="buttons-wrapper">
                <img src="/public/images/pencil.svg" class="edit" data-id="${news.id}">
                <img src="/public/images/close.svg" class="delete" data-id="${news.id}">
            </div>
        </div>
    `;
}
export default News