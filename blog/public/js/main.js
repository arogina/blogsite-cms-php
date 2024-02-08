function toggleReplyVisibility(id) {
  const btnReply = document.getElementById(`btn-reply-${id}`);
  const formReply = document.getElementById(`form-reply-${id}`);

  if (!btnReply.classList.contains("showing")) {
    formReply.style.display = "block";
    btnReply.innerText = "Cancel";
    btnReply.classList.remove("btn-outline-primary");
    btnReply.classList.add("btn-outline-danger");

    btnReply.classList.add("showing");
  } else {
    formReply.style.display = "none";
    btnReply.innerText = "Reply";
    btnReply.classList.remove("btn-outline-danger");
    btnReply.classList.add("btn-outline-primary");

    btnReply.classList.remove("showing");
  }
}
