// function para abrir o modal
document.getElementById("openModal").addEventListener("click", function () {
  document.getElementById("myModal").style.display = "block";
});

// function que fecha o modal
document
  .querySelector("#myModal .close")
  .addEventListener("click", function () {
    document.getElementById("myModal").style.display = "none";
  });
