const stripe = Stripe(stripePublicKey);

const elements = stripe.elements({clientSecret});

document.querySelector("#payment-form").addEventListener("submit", handleSubmit);

const paymentElement = elements.create("payment");

paymentElement.mount("#payment-element");

async function handleSubmit(e) {

    e.preventDefault();
    setLoading(true);

    const {error} = await stripe.confirmPayment({
        elements,
        confirmParams: {
            return_url: redirectAfterSuccessUrl
        }
    });

    // This point will only be reached if there is an immediate error when
    // confirming the payment. Otherwise, your customer will be redirected to
    // your `return_url`. For some payment methods like iDEAL, your customer will
    // be redirected to an intermediate site first to authorize the payment, then
    // redirected to the `return_url`.
    if (error.type === "card_error" || error.type === "validation_error") {
        console.log(error.message);
    } else {
        console.log("An unexpected error occured.");
    }

    setLoading(false);
}

// Show a spinner on payment submission
function setLoading(isLoading) {

    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
    }
}