const authUserId = document.querySelector("#userID").dataset.id;
const receiverId = document.querySelector("#receiverID").dataset.id;
console.log(authUserId, receiverId);

const container = document.getElementById("messages-container");
if (container) {
    container.scrollTop = container.scrollHeight;
}

Echo.private(`chat.user.${authUserId}`).listen("MessageSent", (e) => {
    // console.log(e);
    // console.log("hebebe f chebi ");

    appendMessage(e.message);
});

function appendMessage(message) {
    console.log(message);
    const container = document.getElementById("messages-container");
    const isMine = message.sender_id == authUserId; // مهم double equals لأن dataset id string

    const wrapper = document.createElement("div");
    wrapper.className = isMine ? "flex justify-end" : "flex justify-start";

    if (message.type === "text") {
        console.log("dkhelt l text");
        wrapper.innerHTML = `
            <div class="bg-white text-gray-800 max-w-[65%] px-4 py-2 rounded-2xl shadow border">
                <p class="text-sm break-words">${message.content}</p>
                <span class="text-[11px] text-gray-500 block mt-1">
                    ${new Date(message.created_at).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}
                </span>
            </div>
        `;
    } else if (message.type === "image") {
        console.log("dkhelt l image");

        wrapper.innerHTML = `
            <div class="relative group">
                <img src="/storage/attachment/${message.file_path}"
                    alt="Attachment"
                    class="rounded-xl max-h-64 object-cover border-2 border-white/20 shadow-sm cursor-pointer hover:opacity-90 transition-opacity">
            </div>
        `;
    } else if (message.type === "video") {
        console.log("dkhelt l video");

        wrapper.innerHTML = `
            <div class="bg-white text-gray-800 max-w-[65%] px-4 py-2 rounded-2xl shadow border flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4z" /></svg>
                <video controls class="max-w-xs rounded-lg shadow">
                    <source src="/storage/${message.file_path}" />
                </video>
            </div>
        `;
    } else if (message.type === "file") {
        console.log("dkhelt l file");

        wrapper.innerHTML = `
            <div class="bg-white text-gray-800 max-w-[65%] px-4 py-2 rounded-2xl shadow border flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4z" /></svg>
                <a href="/storage/${message.file_path}" target="_blank" class="text-xs font-bold underline">
                    ${message.content || "Download File"}
                </a>
            </div>
        `;
    }

    container.appendChild(wrapper);
    container.scrollTop = container.scrollHeight;
}
