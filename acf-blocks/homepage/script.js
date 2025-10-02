/**
 * Initializes all Homepage Block scripts.
 * This function is the single entry point for all DOM-dependent initializations of this particular block.
 */

export function initHomePage() {
  heroScript();
}

function heroScript() {
  // Structure your functions for this page like so.
}

// Check if we are in an ACF block preview environment and hook into its render action.
if (window.acf) {
  window.acf.addAction("render_block_preview/type=homepage", initHomePage);
} else {
  document.addEventListener("DOMContentLoaded", initHomePage);
}
