function toggleBookmark(contentId, csrfToken) {
    let bookmarkButton = document.getElementById(`bookmarkButton-${contentId}`);
    let bookmarkIcon = document.getElementById(`bookmarkIcon-${contentId}`);
    let bookmarkCount = document.getElementById(`bookmarkCount-${contentId}`);

    let bookmarked = bookmarkButton.getAttribute("data-bookmarked") === "true";
    let currentCount = parseInt(bookmarkCount.textContent);

    // Optimistic UI update
    if (bookmarked) {
        bookmarkIcon.classList.replace("bxs-bookmark", "bx-bookmark");
        bookmarkIcon.classList.remove("text-[#ffb51b]");
        bookmarkCount.textContent = currentCount - 1;
        bookmarkButton.setAttribute("data-bookmarked", "false");
    } else {
        bookmarkIcon.classList.replace("bx-bookmark", "bxs-bookmark");
        bookmarkIcon.classList.add("text-[#ffb51b]");
        bookmarkCount.textContent = currentCount + 1;
        bookmarkButton.setAttribute("data-bookmarked", "true");
    }

    fetch(`/bookmark/${contentId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json"
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status !== "success") {
            // Rollback UI changes if request fails
            bookmarkIcon.classList.toggle("bxs-bookmark", bookmarked);
            bookmarkIcon.classList.toggle("bx-bookmark", !bookmarked);
            if (bookmarked) {
                bookmarkIcon.classList.add("text-[#ffb51b]");
            } else {
                bookmarkIcon.classList.remove("text-[#ffb51b]");
            }
            bookmarkCount.textContent = currentCount;
            bookmarkButton.setAttribute("data-bookmarked", bookmarked.toString());

            alert(data.message || "Something went wrong!");
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
}
