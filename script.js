document.addEventListener("DOMContentLoaded", () => {
  const pickup = document.getElementById('pickup');
  const drop = document.getElementById('drop');
  const passengers = document.getElementById('passengers');
  const luggages = document.getElementById('luggages');
  const returnBox = document.getElementById('return');
  const summaryBox = document.getElementById('summaryBox');
  const passengerCount = document.getElementById('passengerCount');
  const luggageCount = document.getElementById('luggageCount');

  const routes = Object.keys(priceTable);
  const fromCities = Array.from(new Set(routes.map(route => route.split('-')[0])));

  function populatePickupDropdown() {
    pickup.innerHTML = '<option value="">Select a pickup location</option>';
    fromCities.forEach(city => {
      pickup.innerHTML += `<option value="${city}">${city}</option>`;
    });
  }

  function populateDropDropdown(from) {
    drop.innerHTML = '<option value="">Select a drop-to location</option>';
    const destinations = routes
      .filter(route => route.startsWith(from + '-'))
      .map(route => route.split('-')[1]);

    destinations.forEach(city => {
      drop.innerHTML += `<option value="${city}">${city}</option>`;
    });
  }

  pickup.addEventListener('change', () => {
    populateDropDropdown(pickup.value);
    updateSummary();
  });

  function calculatePrice() {
    const from = pickup.value;
    const to = drop.value;
    const pax = parseInt(passengers.value);
    const isReturn = returnBox.checked;

    const key = `${from}-${to}`;
    let price = 'N/A';

    if (priceTable[key]) {
      if (pax <= 3) price = priceTable[key][0];
      else if (pax <= 6) price = priceTable[key][1];
      else price = priceTable[key][2];

      if (isReturn) price *= 2;
    }

    return price;
  }

    function updateSummary() {
      const form = document.forms.bookingForm;
      const price = calculatePrice();
    
      passengerCount.textContent = passengers.value;
      luggageCount.textContent = luggages.value;
    
      summaryBox.innerHTML = `
        <p><strong>Name:</strong> ${form.name.value}</p>
        <p><strong>Phone No:</strong> ${form.phone.value}</p>
        <p><strong>Passengers:</strong> ${form.passengers.value}</p>
        <p><strong>Luggages:</strong> ${form.luggages.value}</p>
        <p><strong>Pickup Location:</strong> ${form.pickup.value}</p>
        <p><strong>Drop Location:</strong> ${form.drop.value}</p>
        <p><strong>Pickup Date:</strong> ${form.date.value}</p>
        <p><strong>Pickup Time:</strong> ${form.time.value}</p>
        <p><strong>Return Transfer:</strong> ${form.return.checked ? 'Yes' : 'No'}</p>
        <p><strong>Message:</strong> ${form.message.value}</p>
        <p><strong>Total Price:</strong> €${price}</p>
      `;
    }

  ['input', 'change'].forEach(evt => {
    document.getElementById('bookingForm').addEventListener(evt, updateSummary);
  });

  populatePickupDropdown();
  updateSummary();
});
