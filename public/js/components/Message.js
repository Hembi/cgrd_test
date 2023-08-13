const ErrorMessage = function(type, errorMessage)
{

    return `
        <div class="message-wrapper ${type}-message">
            <p>${errorMessage}</p>
        </div>
    `;
}
export default ErrorMessage;