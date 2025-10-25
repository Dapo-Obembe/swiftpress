export function themePreloader() {
  const preloader = document.getElementById("swiftpress-preloader");
  if (!preloader) return;

  const MIN_DISPLAY_TIME = 1500;
  const TRANSITION_DURATION = 1500;
  const startTime = Date.now();

  // Force a reflow to ensure initial state is applied
  preloader.offsetHeight;

  window.addEventListener("load", () => {
    const elapsed = Date.now() - startTime;
    const remaining = Math.max(0, MIN_DISPLAY_TIME - elapsed);

    setTimeout(() => {
      preloader.classList.add("hidden");

      setTimeout(() => {
        preloader.style.display = "none";
      }, TRANSITION_DURATION);
    }, remaining);
  });

  // Intercept internal links
  document.querySelectorAll("a[href]").forEach((link) => {
    try {
      const url = new URL(link.href, window.location.href);
      const sameHost = url.host === window.location.host;

      if (sameHost && !link.target && !link.href.includes("#")) {
        link.addEventListener("click", (e) => {
          e.preventDefault();

          // Show preloader
          preloader.style.display = "flex";

          // Force reflow
          preloader.offsetHeight;

          // Remove hidden class
          preloader.classList.remove("hidden");

          // Navigate after brief delay
          setTimeout(() => {
            window.location.href = link.href;
          }, 800);
        });
      }
    } catch (err) {
      // Handle invalid URLs gracefully
      console.warn("Invalid URL:", link.href);
    }
  });
}
