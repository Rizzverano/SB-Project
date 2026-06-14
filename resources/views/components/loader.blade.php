<div id="loader" class="loader-wrapper">
    <div class="loader">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
        <div class="bar6"></div>
        <div class="bar7"></div>
        <div class="bar8"></div>
        <div class="bar9"></div>
        <div class="bar10"></div>
        <div class="bar11"></div>
        <div class="bar12"></div>
    </div>
</div>

<style>
    /* Loader Container */
.loader-wrapper {
    position: fixed; /* 🔥 makes it overlay entire screen */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    /* white transparent background */
    background: rgba(203, 213, 225, 0.8);

    display: flex;
    justify-content: center;
    align-items: center;

    z-index: 9999; /* 🔥 ensures it's above everything */
}
body.loading {
    overflow: hidden;
}
.loader {
  position: relative;
  width: 54px;
  height: 54px;
  border-radius: 10px;
}

.loader div {
  width: 8%;
  height: 24%;

  position: absolute;
  left: 50%;
  top: 30%;

  opacity: 0;
  border-radius: 50px;

  animation: fade458 1s linear infinite;
}

/* Green bars */
.loader div:nth-child(odd) {
  background: #00c64c; /* green */
  box-shadow: 0 0 6px rgba(0, 198, 167, 0.6);
}

/* Blue bars */
.loader div:nth-child(even) {
  background: #0072ff; /* blue */
  box-shadow: 0 0 6px rgba(0, 114, 255, 0.6);
}

@keyframes fade458 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0.25;
  }
}

/* Rotations */
.loader .bar1 { transform: rotate(0deg) translate(0, -130%); animation-delay: 0s; }
.loader .bar2 { transform: rotate(30deg) translate(0, -130%); animation-delay: -1.1s; }
.loader .bar3 { transform: rotate(60deg) translate(0, -130%); animation-delay: -1s; }
.loader .bar4 { transform: rotate(90deg) translate(0, -130%); animation-delay: -0.9s; }
.loader .bar5 { transform: rotate(120deg) translate(0, -130%); animation-delay: -0.8s; }
.loader .bar6 { transform: rotate(150deg) translate(0, -130%); animation-delay: -0.7s; }
.loader .bar7 { transform: rotate(180deg) translate(0, -130%); animation-delay: -0.6s; }
.loader .bar8 { transform: rotate(210deg) translate(0, -130%); animation-delay: -0.5s; }
.loader .bar9 { transform: rotate(240deg) translate(0, -130%); animation-delay: -0.4s; }
.loader .bar10 { transform: rotate(270deg) translate(0, -130%); animation-delay: -0.3s; }
.loader .bar11 { transform: rotate(300deg) translate(0, -130%); animation-delay: -0.2s; }
.loader .bar12 { transform: rotate(330deg) translate(0, -130%); animation-delay: -0.1s; }
</style>

<script>
        document.body.classList.add('loading');

        window.addEventListener("load", function () {
            setTimeout(() => {
                document.getElementById("loader").style.display = "none";
                document.body.classList.remove('loading');
            }, 2000); // ⏱ 2 seconds
        });
</script>
