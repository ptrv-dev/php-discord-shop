const orderForm = document.querySelector("form.order-form");
const orderValue = document.querySelector(
  'form.order-form input[type="number"]'
);
const orderTotal = document.querySelector(
  "form.order-form .order-form__total strong"
);

const price = Number(
  document.querySelector("form.order-form [data-price]").innerHTML.slice(0, -1)
);

const calculateTotalPrice = () => {
  orderTotal.innerHTML = (price * orderValue.value).toLocaleString("en-US", {
    style: "currency",
    currency: "USD",
  });
};

orderValue.addEventListener("input", (event) => {
  if (Number(event.target.value) < Number(orderValue.min))
    return (event.target.value = Number(orderValue.min));
  if (Number(event.target.value) > Number(orderValue.max))
    return (event.target.value = Number(orderValue.max));
  calculateTotalPrice();
});

window.addEventListener("load", calculateTotalPrice());
