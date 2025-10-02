export function websiteAnimations() {
  initAnimation();
}

// Website Animation Observer.
function initAnimation() {
  const animatedElements = document.querySelectorAll("[data-animate]");

  if (animatedElements.length <= 0) return;

  // // Hide elements initially to prepare for animation
  // animatedElements.forEach((el) => {
  //   el.classList.add("opacity-0");
  // });

  // A Set to track which groups have been animated to prevent re-triggering
  const animatedGroups = new Set();

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const target = entry.target;
          const staggerGroup = target.getAttribute("data-stagger-group");

          // Case 1: Element is part of a stagger group
          if (staggerGroup) {
            // If the group has already been animated, do nothing.
            if (animatedGroups.has(staggerGroup)) {
              return;
            }

            // This is the first visible element of a new group.
            // Mark the group as animated and trigger the animation for all its elements.
            animatedGroups.add(staggerGroup);

            const groupElements = document.querySelectorAll(
              `[data-stagger-group="${staggerGroup}"]`
            );

            // Get the stagger delay amount from the trigger element, or use a default.
            const staggerDelay =
              parseInt(target.getAttribute("data-stagger-delay"), 10) || 100; // Default: 150ms

            groupElements.forEach((el, index) => {
              const animation = el.getAttribute("data-animate");
              const delay = index * staggerDelay;

              el.style.animationDelay = `${delay}ms`;
              el.classList.add(`animate-${animation}`);

              // Stop observing the element once its animation is set
              observer.unobserve(el);
            });
          }
          // Case 2: Element is a standalone animation (original functionality)
          else {
            const animation = target.getAttribute("data-animate");
            const delay = target.getAttribute("data-delay") || "0s";

            target.style.animationDelay = delay;
            target.classList.add(`animate-${animation}`);

            // Stop observing after animation
            observer.unobserve(target);
          }
        }
      });
    },
    {
      threshold: 0.1, // Trigger when 10% of the element is visible
    }
  );

  // Start observing all elements marked for animation
  animatedElements.forEach((element) => {
    observer.observe(element);
  });
}
