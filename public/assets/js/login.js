function login() {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const errorMsg = document.getElementById("error-msg");
  const successMsg = document.getElementById("success-msg");

  if (username === "plnuser" && password === "12345") {
    errorMsg.style.display = "none";
    successMsg.style.display = "block";
    setTimeout(() => {
      alert("Selamat datang di sistem PLN, " + username);
    }, 700);
  } else {
    successMsg.style.display = "none";
    errorMsg.style.display = "block";
  }
}
