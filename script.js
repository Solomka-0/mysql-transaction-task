const userSelect = document.getElementById('user');
const dataDiv = document.getElementById('data');

userSelect.addEventListener('change', function() {
  const userId = this.value;
  if (userId) {
    fetch('data.php?user=' + userId)
        .then(response => response.json())
        .then(balances => {
          displayBalances(balances);
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
  } else {
    dataDiv.innerHTML = '';
  }
});

function displayBalances(balances) {
  if (balances.length === 0) {
    dataDiv.innerHTML = '<p>No transactions found for this user.</p>';
    return;
  }

  const userName = userSelect.options[userSelect.selectedIndex].text;
  let html = "<h2>Transactions of " + userName + "</h2>";
  html += '<table>';
  html += '<tr><th>Month</th><th>Amount</th><th>Days</th></tr>';

  balances.forEach(function(balance) {
    const month = getMonthName(balance.month.slice(5,7)) + ' ' + balance.month.slice(0,4);
    const amount = parseFloat(balance.balance).toFixed(2);
    console.log(balance)
    html += `<tr><td>${month}</td><td>${amount}</td><td>${balance.days_with_transactions}</td></tr>`;
  });

  html += '</table>';
  dataDiv.innerHTML = html;
}

function getMonthName(monthNum) {
  const monthNames = {
    '01': 'January',
    '02': 'February',
    '03': 'March',
    '04': 'April',
    '05': 'May',
    '06': 'June',
    '07': 'July',
    '08': 'August',
    '09': 'September',
    '10': 'October',
    '11': 'November',
    '12': 'December'
  };
  return monthNames[monthNum] || '';
}