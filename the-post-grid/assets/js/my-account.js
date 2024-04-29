var frame;
(function ($) {
    'use strict';

    $("#tpg-category").select2({
        placeholder: "Select Category",
        multiple: true,
    });

    $('#tpg-feature-image2').change(function () {
        var fileSize = this.files[0].size;
        var fileType = this.files[0].type;
        var maxSize = rtTpg.max_upload_size ?? 1048576; // 1MB in bytes
        var inputItem = $(this);

        var allowedTypes = ['image/png', 'image/gif', 'image/jpeg'];
        if(allowedTypes.indexOf(fileType) === -1){
            alert('Only PNG, GIF, and JPEG files are allowed.');
            inputItem.val('');
        }

        if (fileSize > maxSize) {
            alert(rtTpg.file_exceeds_text ?? 'File size exceeds '+ maxSize + 'bytes limit');
            inputItem.val('');
        }
    });


    $("#tpg-feature-image").on("click", function () {
        var self = $(this);
        if (frame) {
            frame.open();
            return false;
        }

        frame = wp.media({
            title: "Select Image",
            button: {
                text: "Insert Image"
            },
        });

        frame.on('select', function () {
            var images = frame.state().get('selection').first().toJSON();

            self.siblings('#tpg-feature-image-id').val(images.id);
            //self.parent().next('.tpg-image-preview').find('img').attr('src', images.sizes.thumbnail.url);

            self.parent().next('.tpg-image-preview').html(`<img src='${images.sizes.thumbnail.url}' />`);
        });


        frame.open();
        return false;
    });


    $('.needs-validation').submit(function (event) {
        let valid = true;

        var isValid = $(this).find('.is-valid');

        isValid.each(function (i) {
            var inputItem = $(this);
            if (inputItem.val().trim() === '') {
                isValid[i].focus()
                inputItem.next().addClass('error')
                valid = false;
            }
        })

        if (!valid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });


    function _tag_add_word(word) {
        var $wrapper = $('.new_tpg_tags'),
            $input = $wrapper.find('#rtpg_post_tag'),
            oldValues = $input.val();
        oldValues = oldValues ? oldValues.split(',').map(function (_item) {
            return _item.trim();
        }) : [];
        oldValues.push(word);
        $input.val(oldValues.join(', '));
        var $content = $('<div><span class="remove">×</span><span class="rtcl-tag-term">' + word + '</span></div>');
        if ($wrapper.find('.tpg-tags-input').find('div').length) {
            $content.insertAfter($wrapper.find('.tpg-tags-input').find('div').last());
        } else {
            $wrapper.find('.tpg-tags-input').prepend($content);
        }
        $wrapper.find('ul').remove();
        $wrapper.find('#new_tpg_tags').val('').focus();
    }

    function rtcl_tag_remove_word(word) {
        var $wrapper = $('.new_tpg_tags'),
            $input = $wrapper.find('#rtcl_listing_tag'),
            currentValues = $input.val();
        currentValues = currentValues ? currentValues.split(',').filter(function (_item) {
            return _item.trim() !== word;
        }) : [];
        $input.val(currentValues.join(', '));
    }

    $('body').on('keydown', '#new_tpg_tags', function (event) {
        if (event.keyCode === 13) {
            var word = $(this).val().trim().replace(',', '');
            if (word) {
                _tag_add_word(word);
            }
            return false;
        }
    });

    $(document).ready(function () {
        if ($('.edit-post-form #new_tpg_tags').length) {
            var word = $('.edit-post-form #new_tpg_tags').val().split(',');

            var filteredArray = word.filter(function (value) {
                return value !== '' && value !== null && value !== undefined && value !== false;
            });
            if (filteredArray.length) {
                $.each(filteredArray, function (i, val) {
                    _tag_add_word(val);
                })
            }
        }
    })

    $('body').on('keyup', '#new_tpg_tags', function (e) {
        var $this = $(this),
            $wrapper = $this.closest('.new_tpg_tags'),
            nonce = $this.closest('form').find('input[name=_wpnonce]').val(),
            searchKey = $this.val(),
            existingVal = $wrapper.find('#rtpg_post_tag').val();

        var data = {
            action: 'tpg_tag_search',
            nonce: nonce,
            q: searchKey,
            number: 20,
            existingVal: existingVal,
        };

        switch (e.keyCode) {
            case 188: //188 - ,
                var word = searchKey.trim().replace(',', '');
                _tag_add_word(word);
                return;
            case 40: //Down Arrow
                if ($wrapper.find("ul li[active]").length === 0) {
                    $wrapper.find('ul li').first().attr('active', '1')
                } else {
                    $wrapper.find('ul li[active]').removeAttr('active').next().attr('active', '1');
                }
                return;
            case 38: //Upper Arrow
                if ($wrapper.find("ul li[active]").length === 0) {
                    $wrapper.find('ul li').last().attr('active', '1');
                } else {
                    $wrapper.find('ul li[active]').removeAttr('active').prev().attr('active', '1');
                }
                return;
            case 13: //Enter
                var $activeList = $wrapper.find("ul li[active]");
                if ($activeList.length) {
                    var _word = $activeList.text();
                    console.log(_word)
                    _tag_add_word(_word);
                    $activeList.removeAttr('active').css('background-color', '#ffffff');
                }
                return;
        }
        if (searchKey.length > 1) {


            $.ajax({
                url: rtTpg.ajaxurl,
                data: data,
                type: "GET",
                dataType: 'json',

                beforeSend: function beforeSend() {
                    $wrapper.find('ul').remove();
                },
                success: function success(response) {
                    $wrapper.append(response.list);
                },
                error: function error(e) {
                    $wrapper.find('ul').remove();
                    console.log(e.responseText);
                }
            });
        } else {
            $wrapper.find('ul').remove();
        }
    }).on('click', '.new_tpg_tags ul li', function () {
        console.log($(this).text())
        _tag_add_word($(this).text());
    }).on('click', '.tpg-tags-input div span.remove', function () {
        var $this = $(this),
            $wrapper = $this.closest('div'),
            termText = $wrapper.find('.rtcl-tag-term').text();
        $this.closest('div').remove();
        rtcl_tag_remove_word(termText);
    });


    $(".tpg-delete-post").on("click", function (e) {
        e.preventDefault();
        if (confirm(rtTpg.confirm_text)) {
            var _self = $(this),
                wrapper = _self.closest(".tpg-post-container"),
                data = {
                    action: "tpg_delete_post",
                    post_id: parseInt(_self.attr("data-id"), 10),
                    rttpg_nonce: rtTpg.nonce
                };
            if (data.post_id) {
                $.ajax({
                    url: rtTpg.ajaxurl,
                    data: data,
                    type: "POST",
                    beforeSend: function beforeSend() {
                        wrapper.addClass('loading');
                    },
                    success: function success(data) {
                        console.log(data)
                        wrapper.removeClass('loading');
                        if (data.success) {
                            wrapper.animate({
                                height: 0,
                                opacity: 0
                            }, "slow", function () {
                                $(this).remove();
                            });
                        }
                    },
                    error: function error() {
                        wrapper.removeClass('loading');
                    }
                });
            }
        }
        return false;
    });

})(jQuery);
