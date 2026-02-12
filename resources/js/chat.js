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
        <div class="px-5 py-3 rounded-2xl shadow-sm {{ $message->sender_id === auth()->id() ? 'bg-indigo-700 text-white rounded-tr-none' : 'bg-indigo-200 text-slate-700 border border-slate-100 rounded-bl-none' }}">
            <div class="bg-white text-gray-800 max-w-[65%] px-4 py-2 rounded-2xl shadow border">
                <p class="text-sm break-words">${message.content}</p>
                <span class="text-[11px] text-gray-500 block mt-1">
                    ${new Date(message.created_at).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}
                </span>
            </div>
        </div>
            `;
    } else if (message.type === "image") {
        console.log("dkhelt l image");

        wrapper.innerHTML = `
        <div class="px-5 py-3 rounded-2xl shadow-sm {{ $message->sender_id === auth()->id() ? 'bg-indigo-700 text-white rounded-tr-none' : 'bg-indigo-200 text-slate-700 border border-slate-100 rounded-bl-none' }}">

        <div class="relative group">
            <img src="/storage/attachment/${message.file_path}"
                alt="Attachment"
                class="rounded-xl max-h-64 object-cover border-2 border-white/20 shadow-sm cursor-pointer hover:opacity-90 transition-opacity">
        </div>
        </div>

        `;
    } else if (message.type === "video") {
        console.log("dkhelt l video");

        wrapper.innerHTML = `
                <div class="px-5 py-3 rounded-2xl shadow-sm {{ $message->sender_id === auth()->id() ? 'bg-indigo-700 text-white rounded-tr-none' : 'bg-indigo-200 text-slate-700 border border-slate-100 rounded-bl-none' }}">

            <div
                class="rounded-xl overflow-hidden border-2 border-white/20 shadow-sm bg-black">
                <video controls class="max-h-64 w-full">
                    <source src="/storage/attachment/${message.file_path}">
                    Your browser does not support the video tag.
                </video>
            </div>
                    </div>

        `;
    } else if (message.type === "file") {
        console.log("dkhelt l file");

        wrapper.innerHTML = `
                <div class="px-5 py-3 rounded-2xl shadow-sm {{ $message->sender_id === auth()->id() ? 'bg-indigo-700 text-white rounded-tr-none' : 'bg-indigo-200 text-slate-700 border border-slate-100 rounded-bl-none' }}">

            <a href="/storage/attachment/${message.file_path}" target="_blank"
                download
                class="flex items-center gap-3 p-3 rounded-xl bg-black/10 hover:bg-black/20 transition-colors border border-white/20 group">
                <div
                    class="p-2 bg-white/20 rounded-lg group-hover:bg-white/30 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold truncate">Attachment</p>
                    <p class="text-[10px] opacity-70">Click to download</p>
                </div>
            </a>
                    </div>

        `;
    }

    container.appendChild(wrapper);
    container.scrollTop = container.scrollHeight;
}
