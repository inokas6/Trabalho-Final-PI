document.getElementById("ling").addEventListener("change", function() {
    const valor = this.value;
    const url = new URL(window.location.href);
    url.searchParams.set("ling", valor);
    window.location.href = url.toString();
  });