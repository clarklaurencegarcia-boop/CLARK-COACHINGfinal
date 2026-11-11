
document.addEventListener("DOMContentLoaded", function () {
    const clgMenuToggle = document.getElementById("menuToggle");
    const clgNavLinks = document.querySelectorAll(".nav-links a");
    const clgSections = document.querySelectorAll("main section");
    const clgContactForm = document.querySelector("#contact form");
    const clgBackToTop = document.querySelector("footer a");

    // Close the mobile navigation after selecting a link
    clgNavLinks.forEach(function (clgLink) {
        clgLink.addEventListener("click", function () {
            if (clgMenuToggle) {
                clgMenuToggle.checked = false;
            }
        });
    });

    // Highlight the navigation link for the current section
    function clgUpdateNavigation() {
        const clgCurrentPosition = window.scrollY + 150;

        clgSections.forEach(function (clgSection) {
            const clgSectionTop = clgSection.offsetTop;
            const clgSectionBottom = clgSectionTop + clgSection.offsetHeight;
            const clgSectionId = clgSection.getAttribute("id");

            if (
                clgCurrentPosition >= clgSectionTop &&
                clgCurrentPosition < clgSectionBottom
            ) {
                clgNavLinks.forEach(function (clgLink) {
                    if (clgLink.getAttribute("href") === "#" + clgSectionId) {
                        clgLink.style.color = "var(--primary)";
                    } else {
                        clgLink.style.color = "";
                    }
                });
            }
        });
    }

    window.addEventListener("scroll", clgUpdateNavigation);
    clgUpdateNavigation();

    // Reveal sections smoothly as they enter the screen
    if ("IntersectionObserver" in window) {
        const clgObserver = new IntersectionObserver(
            function (clgEntries, clgObserverInstance) {
                clgEntries.forEach(function (clgEntry) {
                    if (clgEntry.isIntersecting) {
                        clgEntry.target.style.opacity = "1";
                        clgEntry.target.style.transform = "translateY(0)";
                        clgObserverInstance.unobserve(clgEntry.target);
                    }
                });
            },
            {
                threshold: 0.1
            }
        );

        clgSections.forEach(function (clgSection) {
            if (!clgSection.classList.contains("hero")) {
                clgSection.style.opacity = "0";
                clgSection.style.transform = "translateY(25px)";
                clgSection.style.transition =
                    "opacity 0.7s ease, transform 0.7s ease";

                clgObserver.observe(clgSection);
            }
        });
    }

    // Add a hover-like interaction to client progress cards
    const clgClientCards = document.querySelectorAll("#lessons article");

    clgClientCards.forEach(function (clgCard) {
        clgCard.addEventListener("mouseenter", function () {
            clgCard.style.transform = "translateY(-5px)";
        });

        clgCard.addEventListener("mouseleave", function () {
            clgCard.style.transform = "";
        });
    });

    // Handle the contact form
    if (clgContactForm) {
        clgContactForm.addEventListener("submit", function (clgEvent) {
            clgEvent.preventDefault();

            if (!clgContactForm.checkValidity()) {
                clgContactForm.reportValidity();
                return;
            }

            const clgName = document.getElementById("name").value.trim();
            const clgEmail = document.getElementById("email").value.trim();
            const clgTopic = document.getElementById("topic");
            const clgMessage = document.getElementById("message").value.trim();

            if (!clgName || !clgEmail) {
                alert("Please enter your name and email address.");
                return;
            }

            const clgSelectedTopic =
                clgTopic.options[clgTopic.selectedIndex].text;

            const clgSubject = encodeURIComponent(
                "Coaching Inquiry: " + clgSelectedTopic
            );

            const clgBody = encodeURIComponent(
                "Hello Clark Coaching,\n\n" +
                "Name: " + clgName + "\n" +
                "Email: " + clgEmail + "\n" +
                "Coaching Topic: " + clgSelectedTopic + "\n\n" +
                "Message:\n" + (clgMessage || "No additional message") +
                "\n\nThank you!"
            );

            const clgRecipient = "clarkgarcia2007@gmail.com";

            const clgConfirm = confirm(
                "Your message is ready. Open your email application to send it?"
            );

            if (clgConfirm) {
                window.location.href =
                    "mailto:" + clgRecipient +
                    "?subject=" + clgSubject +
                    "&body=" + clgBody;
            }
        });
    }

    // Smoothly return to the top of the page
    if (clgBackToTop) {
        clgBackToTop.addEventListener("click", function (clgEvent) {
            clgEvent.preventDefault();

            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }

    // Display the current year automatically
    const clgFooterText = document.querySelector("footer p");

    if (clgFooterText) {
        clgFooterText.innerHTML =
            "&copy;" + new Date().getFullYear() +
            " Clark Coaching. All rights reserved.";
    }

    console.log("Clark Coaching JavaScript loaded successfully!");
});
