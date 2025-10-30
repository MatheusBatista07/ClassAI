document.addEventListener("DOMContentLoaded", function () {
  const PUSHER_KEY = "7c0e3086c3a3afbb1b08";
  const PUSHER_CLUSTER = "us2";

  const currentUserId = parseInt(document.body.dataset.userId, 10);
  let activeContactId = null;
  let pusherChannel = null;

  const contactsView = document.getElementById("contacts-view");
  const conversationView = document.getElementById("conversation-view");
  const messageList = document.getElementById("message-list");
  const messageInput = document.getElementById("message-input");
  const sendMessageBtn = document.getElementById("send-message-btn");
  const backButton = document.getElementById("back-to-contacts");
  const conversationAvatar = document.getElementById("conversation-avatar");
  const conversationName = document.getElementById("conversation-name");

  const pusher = new Pusher(PUSHER_KEY, {
    cluster: PUSHER_CLUSTER,
    authEndpoint: '/ClassAI/api.php?action=pusherAuth'
  });

  function appendMessage(text, senderId) {
    const messageDiv = document.createElement("div");
    const messageType = senderId === currentUserId ? "sent" : "received";
    messageDiv.classList.add("message", messageType);
    messageDiv.textContent = text;
    messageList.appendChild(messageDiv);
    messageList.scrollTop = messageList.scrollHeight;
  }

  async function fetchAndDisplayHistory() {
    messageList.innerHTML =
      '<div class="text-center text-muted p-3">Carregando histórico...</div>';

    const url = `/ClassAI/api.php?action=getMessages&userId=${currentUserId}&contactId=${activeContactId}`;

    try {
      const response = await fetch(url);
      if (!response.ok) {
        const errorText = await response.text();
        throw new Error(
          `Falha na API: Status ${response.status}. Resposta do servidor: ${errorText}`
        );
      }

      const messages = await response.json();
      messageList.innerHTML = "";

      if (messages.length === 0) {
        messageList.innerHTML =
          '<div class="text-center text-muted p-3">Seja o primeiro a enviar uma mensagem!</div>';
      } else {
        messages.forEach((msg) => {
          appendMessage(msg.conteudo, parseInt(msg.id_remetente, 10));
        });
      }
    } catch (error) {
      console.error("Erro ao carregar histórico:", error);
      messageList.innerHTML =
        '<div class="text-center text-danger p-3">Não foi possível carregar as mensagens. Verifique o console (F12).</div>';
    }
  }

  async function sendMessage() {
    const messageText = messageInput.value.trim();
    if (messageText === "" || !activeContactId) return;

    const tempMessage = messageText;
    messageInput.value = "";

    const url = "/ClassAI/api.php?action=sendMessage";

    try {
      const response = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          senderId: currentUserId,
          receiverId: activeContactId,
          message: tempMessage,
        }),
      });

      if (!response.ok) {
        const errorText = await response.text();
        throw new Error(
          `Falha na API ao enviar: Status ${response.status}. Resposta: ${errorText}`
        );
      }
    } catch (error) {
      console.error("Erro ao enviar mensagem:", error);
      alert("Não foi possível enviar a mensagem.");
      messageInput.value = tempMessage;
    }
  }

  function subscribeToChannel() {
    if (pusherChannel) {
        pusher.unsubscribe(pusherChannel.name);
    }
    
    const channelName = `presence-chat-${Math.min(currentUserId, activeContactId)}-${Math.max(currentUserId, activeContactId)}`;
    pusherChannel = pusher.subscribe(channelName);

    const statusElement = document.getElementById('conversation-status');

    pusherChannel.bind('pusher:subscription_succeeded', (members) => {
        const isOnline = members.count > 1;
        statusElement.textContent = isOnline ? 'Online' : 'Offline';
        statusElement.className = `chat-status ${isOnline ? 'online' : 'offline'}`;
    });

    pusherChannel.bind('pusher:member_added', (member) => {
        statusElement.textContent = 'Online';
        statusElement.className = 'chat-status online';
    });

    pusherChannel.bind('pusher:member_removed', (member) => {
        statusElement.textContent = 'Offline';
        statusElement.className = 'chat-status offline';
    });

    pusherChannel.bind('new-message', (data) => {
        if ((parseInt(data.senderId, 10) === currentUserId && parseInt(data.receiverId, 10) === activeContactId) ||
            (parseInt(data.senderId, 10) === activeContactId && parseInt(data.receiverId, 10) === currentUserId)) {
            appendMessage(data.message, parseInt(data.senderId, 10));
        }
    });
  }

  function openConversation(contactElement) {
    activeContactId = parseInt(contactElement.dataset.contactId, 10);
    conversationAvatar.src = contactElement.dataset.contactAvatar;
    conversationName.textContent = contactElement.dataset.contactName;

    const status = contactElement.dataset.contactStatus;
    const statusElement = document.getElementById("conversation-status");
    statusElement.textContent = status === "online" ? "Online" : "Offline";
    statusElement.className = `chat-status ${status}`;

    fetchAndDisplayHistory();
    subscribeToChannel();
    contactsView.style.display = "none";
    conversationView.style.display = "flex";
    messageInput.focus();
  }

  function backToContacts() {
    if (pusherChannel) {
      pusher.unsubscribe(pusherChannel.name);
      pusherChannel = null;
    }
    activeContactId = null;
    contactsView.style.display = "block";
    conversationView.style.display = "none";
  }

  document.querySelectorAll(".chat-item").forEach((item) => {
    item.addEventListener("click", () => openConversation(item));
  });

  backButton.addEventListener("click", backToContacts);
  sendMessageBtn.addEventListener("click", sendMessage);

  messageInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      sendMessage();
    }
  });

  const menuToggle = document.querySelector(".header_mobile .bi-list");
  if (menuToggle) {
    menuToggle.addEventListener("click", () =>
      document.body.classList.toggle("sidebar-open")
    );
  }
});
