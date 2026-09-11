function initSelect2(selector, url, placeholder, onSelectCallback = null) {
  if ($(selector).hasClass('select2-hidden-accessible')) {
    $(selector).select2('destroy');
  }

  $(selector).select2({
    placeholder: placeholder,
    width: '100%',
    ajax: {
      url: url,
      type: "GET",
      dataType: 'JSON',
      delay: 250,
      data: function (params) {
        return { searchTerm: params.term };
      },
      processResults: function (response) {
        return { results: response };
      }
    }
  });

	// Optional Modular Callback
  if (onSelectCallback) {
    $(selector).on('select2:select', function (e) {
      onSelectCallback(e.params.data);
    });
  }
}

// ?

let gasOptions = [];

function fetchGasesOptions(url, filter = 'all') {
  return $.ajax({ url: url, type: 'GET', dataType: 'JSON' })
    .then(response => {
      const filtered = filter === 'konsolidasi'
        ? response.filter(item => item.text !== 'Liquid Oxygen')
        : response;

      gasOptions = filtered.map(item => ({
        id: String(item.id),
        text: item.gases,
        jumlah: item.stock
      }));

      return gasOptions;
    })
    .catch(xhr => {
      console.error("Error Fetching Gases Options:", xhr.responseText);
      throw xhr;
    });
}

function initGasesDropdowns(targetName = "gases[]") {
  $(`select[name='${targetName}']`).each(function () {
    $(this).select2({
      placeholder: "Pilih Gas",
      width: '100%',
      data: [{ id: '', text: 'Pilih Gas' }, ...gasOptions]
    });
  });
}

function updateGasesDropdowns(targetName = "gases[]") {
  const $selects = $(`select[name='${targetName}']`);
  const selectedValues = $selects.map(function () { return $(this).val(); }).get().filter(Boolean);

  $selects.each(function () {
    const $select = $(this);
    const currentValue = $select.val();

    const filteredOptions = gasOptions.filter(
      opt => !selectedValues.includes(opt.id) || opt.id === currentValue
    );

    $select.empty();
    $select.append(new Option("Pilih Gas", "", false, false));
    filteredOptions.forEach(opt => {
      $select.append(new Option(opt.text, opt.id, false, opt.id === currentValue));
    });

    $select.trigger('change.select2');
  });
}

function globalgases(url, targetName = "gases[]", filter = "all", totalinput = null) {
  return fetchGasesOptions(url, filter).then(() => {
    initGasesDropdowns(targetName);

    $(document).off(`change.globalgases-${targetName}`).on(`change.globalgases-${targetName}`, `select[name='${targetName}']`, function () {
      updateGasesDropdowns(targetName);
      if (!totalinput) return;

      const $select = $(this);
      const selectedGasId = $select.val();
      const $targetInput = $select.closest('tr, .row, .form-group').find('.' + totalinput);
      if ($targetInput.length === 0) return;

      const selectedGas = selectedGasId ? gasOptions.find(opt => opt.id === selectedGasId) : null;
      $targetInput.val(selectedGas && typeof selectedGas.jumlah !== 'undefined' ? selectedGas.jumlah : '');
    });
  });
}