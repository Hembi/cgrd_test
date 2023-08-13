import News from '../components/News.js';
const NewsList = function(newsList)
{
    return `
        <div class="news-list-wrapper">
            <h3>All News</h3>
            ${newsList.map(News).join('')}
        </div>
    `;
}
export default NewsList