const authUserId = document.querySelector('#userID').dataset.id ;
const receiverId = document.querySelector('#receiverID').dataset.id ;
console.log(authUserId, receiverId);


const container = document.getElementById("messages-container");
if (container) {
    container.scrollTop = container.scrollHeight;
}

Echo.private(`chat.user.${authUserId}`).listen("MessageSent", (e) => {
    console.log("New message:", e);
    console.log("hebebe f chebi ");

    appendMessage(e.message);
});

function appendMessage(message) {
    const container = document.getElementById("messages-container");

    const isMine = message.sender_id === authUserId;

    const wrapper = document.createElement("div");
    wrapper.className = isMine ? "flex justify-end" : "flex justify-start";

    wrapper.innerHTML = `
            <div class="bg-white text-gray-800 max-w-[65%] px-4 py-2 rounded-2xl shadow border">
                <p class="text-sm break-words">${message.content}</p>
                <span class="text-[11px] text-gray-500 block mt-1">
                    ${new Date(message.created_at).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}
                </span>
            </div>
        `;

    container.appendChild(wrapper);
    container.scrollTop = container.scrollHeight;
}
