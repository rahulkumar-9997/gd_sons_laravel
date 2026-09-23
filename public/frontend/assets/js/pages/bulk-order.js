(function ($) {
    'use strict';

    $(function () {
        var $form = $('#bulkForm');
        if (!$form.length) return;

        var $btn    = $('#bulkSubmit');
        var $status = $('#formStatus');
        var $date   = $('#f-date');
        var ERR_CLS = '!border-red-400';
        var fp      = null;

        /* ---------- Datepicker ---------- */
        function tomorrow() {
            var d = new Date();
            d.setDate(d.getDate() + 1);
            return d;
        }
        function toYmd(d) {
            return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
        }

        if (typeof window.flatpickr === 'function') {
            fp = window.flatpickr($date[0], {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd M Y',
                minDate: tomorrow(),
                disableMobile: true,
                allowInput: false,
                onReady: function (sel, str, inst) {
                    inst.altInput.setAttribute('placeholder', 'Select date');
                },
                onChange: function () {
                    clearFieldError($date.closest('[data-field]'));
                }
            });
        } else {
            $date.attr({ type: 'date', min: toYmd(tomorrow()) }).removeAttr('readonly');
        }

        /* ---------- Input helpers ---------- */
        $form.on('input', '[name="phone"]', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
        $form.on('input', '[name="budget"]', function () {
            var digits = this.value.replace(/\D/g, '');
            this.value = digits ? Number(digits).toLocaleString('en-IN') : '';
        });

        /* ---------- Error helpers ---------- */
        function visibleInputs($wrap) {
            return $wrap.find('input:not([type=hidden]):not([type=radio]), textarea');
        }
        function showError(name, msg) {
            var $wrap = $form.find('[name="' + name + '"]').first().closest('[data-field]');
            if (!$wrap.length) return;
            $wrap.find('.err').text(msg).removeClass('hidden');
            visibleInputs($wrap).addClass(ERR_CLS);
        }
        function clearFieldError($wrap) {
            $wrap.find('.err').text('').addClass('hidden');
            visibleInputs($wrap).removeClass(ERR_CLS);
        }
        function clearErrors() {
            $form.find('[data-field]').each(function () { clearFieldError($(this)); });
        }
        $form.on('input change', 'input, textarea', function () {
            clearFieldError($(this).closest('[data-field]'));
        });

        function setStatus(type, msg) {
            $status
                .removeClass('hidden bg-primary-mint text-primary-navy bg-red-50 text-red-700')
                .addClass(type === 'success' ? 'bg-primary-mint text-primary-navy' : 'bg-red-50 text-red-700')
                .text(msg);
        }
        function setLoading(on) {
            $btn.prop('disabled', on);
            $btn.find('.btn-text').text(on ? 'Sending…' : 'Send Enquiry');
            $btn.find('.btn-arrow').toggleClass('hidden', on);
            $btn.find('.btn-spin').toggleClass('hidden', !on);
        }
        function scrollToFirstError() {
            var $first = $form.find('.err:not(.hidden)').first().closest('[data-field]');
            if ($first.length) {
                $('html, body').animate({ scrollTop: $first.offset().top - 120 }, 300);
            }
        }
        function val(name) {
            var $el = $form.find('[name="' + name + '"]');
            if ($el.is(':radio')) return ($el.filter(':checked').val() || '').trim();
            return ($el.val() || '').trim();
        }

        /* ---------- AJAX submit (server-side validation) ---------- */
        $form.on('submit', function (e) {
            e.preventDefault();
            clearErrors();
            $status.addClass('hidden');
            setLoading(true);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .done(function (res) {
                if (res && res.success) {
                    setStatus('success', res.message);
                    $form[0].reset();
                    if (fp) fp.clear();
                } else {
                    setStatus('error', (res && res.message) || 'Something went wrong. Please try again.');
                }
            })
            .fail(function (xhr) {
                var res = xhr.responseJSON || {};

                if (xhr.status === 422 && res.errors) {
                    $.each(res.errors, function (name, msgs) {
                        showError(name, msgs[0]);
                    });
                    setStatus('error', res.message || 'Please correct the highlighted fields.');
                    scrollToFirstError();
                } else if (xhr.status === 429) {
                    setStatus('error', 'Too many attempts. Please wait a minute and try again.');
                } else if (xhr.status === 419) {
                    setStatus('error', 'Session expired. Please refresh the page and try again.');
                } else if (xhr.status === 0) {
                    setStatus('error', 'Network error. Please check your connection.');
                } else {
                    setStatus('error', res.message || 'Something went wrong. Please try again or send on WhatsApp.');
                }
            })
            .always(function () {
                setLoading(false);
            });
        });

        /* ---------- Send on WhatsApp ---------- */
        $('#waSend').on('click', function (e) {
            e.preventDefault();
            var dateText = fp && fp.selectedDates.length ? fp.altInput.value : val('delivery_date');
            var lines = [
                'Hello GD Sons, I want a bulk order quote.',
                val('name')         ? 'Name: ' + val('name') : '',
                val('phone')        ? 'Phone: ' + val('phone') : '',
                val('location')     ? 'Location: ' + val('location') : '',
                val('budget')       ? 'Budget: ₹' + val('budget') : '',
                val('quantity')     ? 'Quantity: ' + val('quantity') : '',
                dateText            ? 'Delivery by: ' + dateText : '',
                val('gift_wrapped') ? 'Gift wrapped: ' + val('gift_wrapped') : '',
                val('requirement')  ? 'Requirement: ' + val('requirement') : ''
            ].filter(Boolean);

            window.open('https://wa.me/919935070000?text=' + encodeURIComponent(lines.join('\n')), '_blank', 'noopener');
        });
    });
})(jQuery);