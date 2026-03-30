document.addEventListener("DOMContentLoaded", () => {
	document.querySelectorAll("[data-toggle=\"dropdown-menu\"]").forEach((btn) => {
		btn.addEventListener("click", () => {
			let dropDown = btn.nextElementSibling

			if (dropDown.getAttribute("aria-expended") === "false") {
				dropDown.setAttribute("aria-expended", true)
			} else {
				dropDown.setAttribute("aria-expended", false)
			}
		})
	})
});
