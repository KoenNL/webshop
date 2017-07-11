function ucFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/**
 * Add a new feature panel for the given feature.
 * @param idFeature
 * @returns {boolean}
 */
function addFeaturePanel(idFeature) {
    if (!idFeature) {
        return false;
    }
    var postData = {idFeature: idFeature};
    $.post('/adminproduct/getfeaturevalues', postData, function (response) {
        if (!response.feature) {
            return alert(response.message);
        }
        var feature = response.feature;
        var panelId = 'feature' + idFeature;
        $('.feature-panel.clone').clone().appendTo('#feature-panels');
        $('#feature-panels .feature-panel.clone:last').attr('id', panelId);
        $('#' + panelId).removeClass('clone');

        $('#' + panelId + ' .panel-heading').html(ucFirst(feature.name));

        for (var i = 0, length = feature.featureValues.length; i < length; i++) {
            var featureValue = feature.featureValues[i];
            var checkboxId = 'feature-value-' + featureValue.idFeatureValue;

            addFeatureValueCheckbox(panelId, idFeature, checkboxId, featureValue);
        }

        $('#' + panelId + ' .add-new-feature-value').attr('data-id-feature', idFeature);

        $('#add-feature option[value="' + idFeature + '"]').attr('disabled', true);
        $('#add-feature option[value="' + idFeature + '"]').attr('selected', false);

        return true;
    });
}

/**
 * Ads a new checkbox to the feature values of the given feature.
 * @param panelId
 * @param idFeature
 * @param checkboxId
 * @param featureValue
 * @returns {boolean}
 */
function addFeatureValueCheckbox(panelId, idFeature, checkboxId, featureValue) {
    $('#' + panelId + ' .checkbox.clone').clone().appendTo('#' + panelId + ' .feature-values').removeClass('clone');
    $('#' + panelId + ' .feature-values input.checkbox:not(.clone):last').attr('id', checkboxId);
    $('#' + checkboxId).attr('name', 'features[' + idFeature + '][' + featureValue.idFeatureValue + ']');
    $('#' + checkboxId).parent('label').attr('for', checkboxId);
    $('#' + checkboxId).parent('label').append(ucFirst(featureValue.value));

    return true;
}

/**
 * Add a new feature value.
 * @param idFeature
 * @returns {boolean}
 */
function addNewFeatureValue(idFeature) {
    if (!idFeature) {
        return false;
    }
    var panelId = 'feature' + idFeature;
    var value = $('#' + panelId + ' .new-feature-value').val();
    if (!value) {
        return false;
    }

    var postData = {idFeature: idFeature, value: value};
    $.post('/adminproduct/addfeaturevalue', postData, function (response) {
        if (!response.featureValue) {
            return alert(response.message);
        }
        var featureValue = response.featureValue;
        var checkboxId = 'feature-value-' + featureValue.idFeatureValue;

        addFeatureValueCheckbox(panelId, idFeature, checkboxId, featureValue);

        $('#' + panelId + ' .new-feature-value').val('');

        return true;
    });
}

function changeOrderLineAmount(idVariation, amount)
{
    if (!idVariation) {
        return false;
    }
    var postData = {idVariation: idVariation, amount: amount};
    $.post('/order/changeorderlineamount', postData, function (response) {
        if (response.redirect) {
            window.location.replace(response.redirect);
        }
    });
}

$(document).on('click', '#add-feature-button', function () {
    addFeaturePanel($('#add-feature').val());
});

$(document).on('click', '.add-new-feature-value', function() {
    addNewFeatureValue($(this).attr('data-id-feature'));
});

$(document).on('change', '.change-order-line-amount', function() {
    var amount = $(this).val();
    var idVariation = $(this).attr('data-id-variation');

    changeOrderLineAmount(idVariation, amount);
});

$(document).on('click', '.remove-order-line', function() {
    var idVariation = $(this).attr('data-id-variation');

    changeOrderLineAmount(idVariation);
});

$(document).on('click', '.checkbox-submit', function() {
    $(this).parents('form').submit();
});