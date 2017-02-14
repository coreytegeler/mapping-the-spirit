// Generated by CoffeeScript 1.10.0
(function() {
  var indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  $(function() {
    var $aid, $body, $collection, $collectionItems, $frame, $grid, $header, $itemTitle, $main, $pageTitle, $secondary, $table, $window, addToCollection, browseCollection, browserNav, buildGrid, checkSize, clickItem, clickLink, closeDur, closeFrame, closeSingle, collect, collectSingle, createCollectionItem, createSingle, dragAndDrop, frameTool, goBack, horzScroll, hoverRow, init, insertCollection, loadCollection, loadImages, loadSingle, loadedSlug, lookAt, lookAway, makeResizable, noHover, openDur, paginate, pickUp, putDown, putDownAll, removeCollectedItem, resizeCollection, resizeFolder, resizeFrameBar, resizeGrid, saveCollection, scrollInterval, scrollShift, shiftAndRotate, sizeImage, toggleFolder, transEnd, uncollect, unhoverRow, vertScroll, zoomImage;
    $window = $(window);
    $body = $('body');
    $main = $('main');
    $header = $('header');
    $itemTitle = $header.find('.title.item');
    $grid = $('#grid');
    $aid = $('#aid');
    $frame = $('#frame');
    $pageTitle = $header.find('.pageTitle span');
    $secondary = $header.find('.secondary');
    $table = $('#table');
    $collection = $('#collection');
    $collectionItems = $collection.find('.items');
    transEnd = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd';
    loadedSlug = $('.single:last-child').attr('data-slug');
    scrollInterval = null;
    scrollShift = 0;
    init = function() {
      var data, slug;
      noHover();
      dragAndDrop();
      loadCollection();
      $body.on('mousewheel', '.horzScroll', function(event) {
        return horzScroll(this, event);
      });
      $body.scroll(function(event) {
        return vertScroll(this, event);
      });
      $body.on('mousemove', function(e) {
        return $(this).find('.shift').each(function() {
          return shiftAndRotate(this, e);
        });
      });
      $body.on('click', '.button.collect', collectSingle);
      $body.on('click', '.button.close-single', closeSingle);
      $body.on('click', '.close-singles', putDownAll);
      $body.on('mousemove', '#collection', browseCollection);
      $body.on('click', '.item.click', clickItem);
      $body.on('mouseover', '.item.click', lookAt);
      $body.on('mouseleave', '.item.click', lookAway);
      $body.on('click', '.single.folder .handle', toggleFolder);
      $body.on('click', '.block.image:not(.noZoom) img', zoomImage);
      $body.on('click', '#frame-bar .tools div', frameTool);
      $body.on('click', '.single .paginate', paginate);
      $body.on('click', '.single .block a.item', clickLink);
      $body.on('click', '#error a.back', goBack);
      $body.on('mouseover', '.row a', hoverRow);
      $body.on('mouseleave', '.row a', unhoverRow);
      $(window).on('popstate', function(e) {
        e.preventDefault();
        return browserNav(e);
      });
      if ($body.is('.looking')) {
        slug = $('.single').attr('data-slug');
        data = {
          action: 'up',
          slug: slug
        };
        history.replaceState(data, document.title, window.location.href);
        loadSingle($('.single'));
      }
      if ($grid) {
        buildGrid();
      }
      loadImages();
      checkSize();
      resizeFolder();
      $('.shift').each(function() {
        return shiftAndRotate(this);
      });
      $body.addClass('loaded');
      return $(window).resize(function() {
        if (checkSize('phone')) {
          $('.resizable').resizable('disable');
          $('.resizable').find('.text').each(function() {
            return $(this).attr('style', '');
          });
        } else {
          $('.resizable').resizable('enable');
          resizeGrid();
        }
        resizeFolder();
        resizeCollection();
        return resizeFrameBar();
      }).resize();
    };
    buildGrid = function() {
      var gutter;
      gutter = $grid.find('.gutter').innerWidth();
      if (!checkSize('phone')) {
        $grid.isotope({
          layoutMode: 'masonryHorizontal',
          itemSelector: '.item',
          percentPosition: false,
          gutter: gutter,
          transitionDuration: 0,
          masonryHorizontal: {
            rowHeight: '.sizer',
            gutter: gutter,
            percentPosition: true,
            transitionDuration: 0
          },
          animationOptions: {
            duration: 0
          }
        });
      }
      $grid.addClass('loaded');
      resizeGrid();
      return vertScroll();
    };
    resizeGrid = function() {
      var gutter;
      if (!checkSize('phone') && $grid.is('.loaded')) {
        gutter = $grid.find('.gutter').innerWidth();
        return $grid.find('.item').each(function() {
          sizeImage(this, gutter);
          return $grid.isotope('layout');
        });
      }
    };
    loadImages = function() {
      return $('img.load').each(function(i, img) {
        var $img, $item, src;
        $img = $(img);
        $item = $($img.parents('.item')[0]);
        $item.addClass('has-loader');
        src = $img.data('src');
        $item.append('<div class="loader"></div>');
        $img.attr('src', src);
        sizeImage($item);
        if ($item.parents('#grid')) {
          resizeGrid();
        }
        return $item.imagesLoaded(function() {
          $item.addClass('loaded');
          $img.removeClass('load');
          $img.css('width', '');
          $img.css('height', '');
          $img.css('maxHeight', '');
          $item.css('width', '');
          $item.css('height', '');
          $item.css('maxHeight', '');
          if ($item.parents('#table').length) {
            if ($grid.is('.loaded')) {
              resizeGrid();
            }
            return resizeCollection();
          }
        });
      });
    };
    sizeImage = function(item, gutter) {
      var $img, $item, height, ratio, width;
      $item = $(item);
      $img = $item.find('img');
      ratio = $img.data('height') / $img.data('width');
      if (gutter) {
        if ($item.is('.large')) {
          height = $table.innerHeight() - gutter * 2;
        } else {
          height = $table.innerHeight() / 2 - gutter * 1.5;
        }
        width = height / ratio;
      } else {
        width = $item.parents('.block').innerWidth();
        height = width / ratio;
      }
      $item.css({
        height: height,
        maxHeight: height
      });
      $img.css({
        height: height,
        maxHeight: height
      });
      if (!$item.is('.show')) {
        $item.css({
          width: width
        });
        return $item.addClass('show');
      } else {
        return $img.width('');
      }
    };
    vertScroll = function(self, event) {
      var $section, paddingTop, sectionTop, vertScrollTop;
      vertScrollTop = $main.scrollTop();
      $section = $header.parents('section');
      if (!$section.length) {
        return;
      }
      sectionTop = $section.offset().top;
      if (sectionTop <= 0) {
        $header.addClass('fixed');
        paddingTop = $header.innerHeight();
      } else {
        $header.removeClass('fixed');
        paddingTop = 0;
      }
      return $section.css({
        paddingTop: paddingTop
      });
    };
    horzScroll = function(self, event) {
      var delta;
      if ($grid.length) {
        if (checkSize('phone')) {
          return;
        }
        delta = event.deltaY;
        if (delta !== 0) {
          event.preventDefault();
          return self.scrollLeft -= delta;
        }
      }
    };
    dragAndDrop = function() {
      var gutter;
      gutter = $grid.find('.gutter').innerWidth();
      $grid.find('.item').draggable({
        containment: 'body',
        helper: 'clone',
        snap: '#collection',
        snapMode: 'inner',
        snapTolerance: 0,
        appendTo: 'body',
        scroll: false,
        cursorAt: {
          left: 0,
          top: 0
        },
        start: function(event, ui) {
          var $helper;
          $helper = $(ui.helper);
          $helper.addClass('helper');
          return $grid.addClass('dragging');
        },
        drag: function(event, ui) {
          var $helper, collectionTop, itemTop;
          $helper = $(ui.helper);
          $helper.css('transform', '');
          itemTop = ui.offset.top;
          collectionTop = $collectionItems.offset().top;
          if (itemTop >= collectionTop - 1) {
            return $helper.addClass('over');
          } else {
            return $helper.removeClass('over');
          }
        },
        stop: function(event, ui) {
          var $helper;
          $helper = $(ui.helper);
          $helper.removeClass('helper');
          return $grid.removeClass('dragging');
        }
      });
      $collection.droppable({
        accept: '.item.droppable',
        drop: function(event, ui) {
          var item;
          $(this).removeClass('over');
          item = $(ui.draggable[0]).data('slug');
          return collect(item);
        },
        over: function(event, ui) {
          return $collection.addClass('over');
        },
        out: function(event, ui) {
          return $collection.removeClass('over');
        }
      });
      $table.droppable({
        accept: '.item',
        drop: function(event, ui) {
          var $helper, item;
          $helper = ui.helper;
          if ($helper.is('.deletable')) {
            item = $helper.data('slug');
            return uncollect(item);
          }
        },
        over: function(event, ui) {
          var $helper;
          $helper = ui.helper;
          $helper.addClass('deleting');
          return $('#collection .placeholder').addClass('hide');
        },
        out: function(event, ui) {
          var $helper;
          $helper = ui.helper;
          $helper.removeClass('deleting');
          return $('#collection .placeholder').removeClass('hide');
        }
      });
      return $collectionItems.sortable({
        items: '> .item',
        containment: 'body',
        helper: 'clone',
        snap: '#collection .items',
        snapMode: 'inner',
        snapTolerance: 0,
        scroll: false,
        placeholder: 'placeholder',
        forcePlaceholderSize: true,
        start: function(event, ui) {
          var $helper;
          $helper = $(ui.helper);
          $helper.addClass('deletable');
          return $collection.addClass('sorting');
        },
        stop: function(event, ui) {
          var storySlug;
          $collection.removeClass('sorting');
          storySlug = $(ui.helper).attr('data-story');
          return saveCollection();
        }
      });
    };
    collect = function(slug) {
      var $img, $item, storySlug, thumb;
      $item = $grid.find('[data-slug="' + slug + '"]').clone();
      $item.removeClass('shift rotate droppable');
      $item.addClass('collected');
      $item.attr('style', '');
      if (($img = $item.find('img'))) {
        $img.attr('style', '');
        thumb = $item.attr('data-thumb');
        $img = $item.find('img');
        $img.attr('data-src', thumb);
        $img.attr('src', thumb);
      }
      storySlug = $item.attr('data-story');
      if ($collection.find('[data-slug="' + slug + '"]').length) {
        return;
      }
      $collection.removeClass('empty');
      $collectionItems.append($item);
      resizeCollection();
      saveCollection();
      resizeCollection();
      return $item.imagesLoaded(function() {
        return setTimeout(function() {
          return resizeCollection();
        }, 100);
      });
    };
    uncollect = function(slug) {
      var $item, story;
      $item = $collection.find('[data-slug="' + slug + '"]');
      story = $item.data('story');
      $item.remove();
      return setTimeout(function() {
        removeCollectedItem(story, slug);
        if (!$collection.find('.item').length) {
          return $collection.addClass('empty');
        }
      }, 1);
    };
    clickItem = function(e) {
      var $item, $single, slug;
      if (!$grid) {
        return;
      }
      e.preventDefault();
      $item = $(this);
      if ($item.is('.selected')) {
        slug = $item.attr('data-slug');
        $single = $('.single[data-slug="' + slug + '"]');
        if ($single.is(':last-of-type')) {
          putDown(slug);
          return;
        }
        $single.addClass('swap');
        $main.append($single);
        return setTimeout(function() {
          return $single.removeClass('swap');
        }, 100);
      } else if ($item.is('.collected') && $body.is('.looking')) {
        return pickUp($item, true, true);
      } else if (!$body.is('.looking')) {
        return pickUp($item, true, true);
      }
    };
    paginate = function(e) {
      var $arrow, $item, slug;
      e.preventDefault();
      $arrow = $(e.target);
      slug = $arrow.attr('data-slug');
      $item = $grid.find('.item[data-slug="' + slug + '"]');
      putDown(slug);
      if ($item.length) {
        return pickUp($item, true, false);
      }
    };
    openDur = 600;
    closeDur = 300;
    pickUp = function(item, push, over) {
      var $collected, $item, index, slug, storySlug, title, url;
      $item = $(item);
      index = $item.attr('data-index');
      slug = $item.attr('data-slug');
      url = $item.attr('href');
      title = $item.attr('data-title');
      storySlug = $item.attr('data-story');
      $collection.find('.selected').removeClass('selected');
      $collected = $collection.find('[data-slug="' + slug + '"]');
      $collected.addClass('selected');
      $body.addClass('looking').addClass('waiting');
      $main.append('<div class="loader window"></div>');
      return setTimeout(function() {
        $main.addClass('has-loader');
        return createSingle(url, slug, push, over);
      });
    };
    createSingle = function(url, slug, push, over) {
      var data;
      if (push) {
        data = {
          action: 'up',
          slug: slug
        };
        history.pushState(data, document.title, url);
      }
      return $.ajax({
        url: url,
        dataType: 'html',
        error: function(jqXHR, status, err) {
          return console.log(jqXHR, status, err);
        },
        success: function(html, status, jqXHR) {
          var $content, $data, $single, title, type;
          $single = $('<div class="single"></div>');
          $main.append($single);
          $data = $($(html)[0]);
          title = $data.data('title');
          slug = $data.data('slug');
          type = $data.data('type');
          url = $data.data('url');
          $data.remove();
          $content = $($(html));
          $single.attr('data-title', title).attr('data-slug', slug).attr('data-type', type).attr('data-url', url).addClass(type);
          $single.html($content);
          $single.find('.rotate').each(function() {
            return shiftAndRotate(this);
          });
          document.title = 'Mapping The Spirit — ' + title;
          $itemTitle.addClass('ready');
          $itemTitle.find('a').html(title);
          $itemTitle.find('a').attr('href', url);
          return setTimeout(function() {
            $itemTitle.addClass('show');
            loadSingle($single);
            $single.on(transEnd, function() {
              var $behind;
              $main.removeClass('has-loader');
              $single.prev('.loader').remove();
              $single.off(transEnd);
              $behind = $single.prev('.single:eq(0)');
              if ($behind.length && !over) {
                setTimeout(function() {
                  return $behind.remove();
                });
                return 500;
              }
            });
            return $single.addClass('open');
          }, 300);
        }
      });
    };
    loadSingle = function(single) {
      var $collectedItem, $single, slug, story;
      makeResizable(single);
      $single = $(single);
      $single.addClass('loaded');
      slug = $single.attr('data-slug');
      story = $table.attr('data-story');
      $collectedItem = $collection.find('.item[data-slug="' + slug + '"]');
      if ($collectedItem.length) {
        $collectedItem.addClass('selected');
        $single.find('.button.collect').removeClass('add').addClass('remove');
      }
      $body.removeClass('waiting');
      loadImages();
      $single.on('progress', function(inst, image) {
        var $item;
        $item = $(image.img).parents('.item');
        return $item.addClass('loaded');
      });
      return $single.find('.block a').each(function() {
        var search, url;
        url = this.href;
        search = '/stories/' + story + '/';
        if (url.indexOf(search) <= -1) {
          return $(this).attr('target', '_blank');
        } else {
          return $(this).addClass('item');
        }
      });
    };
    putDown = function(slug, push) {
      var $collected, $newSingle, $openSingles, $single, data, scrollLeft, title, url;
      $single = $('.single[data-slug="' + slug + '"]');
      url = $table.data('url');
      console.log(url);
      if (push) {
        data = {
          action: 'down',
          slug: slug
        };
        history.pushState(data, document.title, url);
      }
      $collected = $('#collection .item[data-slug="' + slug + '"]').removeClass('selected');
      scrollLeft = $table.scrollLeft();
      $single.on(transEnd, function() {
        $single.off(transEnd);
        $single.remove();
        if (!$('.single').length) {
          $itemTitle.removeClass('ready');
          return $body.removeClass('looking');
        }
      });
      $single.removeClass('open');
      $openSingles = $('.single.open');
      if (!$openSingles.length) {
        $itemTitle.removeClass('show');
        return document.title = 'Mapping The Spirit — ' + $main.data('title');
      } else {
        $newSingle = $($openSingles[$openSingles.length - 1]);
        title = $newSingle.data('title');
        document.title = 'Mapping The Spirit — ' + title;
        $itemTitle.find('a').html();
        return $itemTitle.find('a').attr('href', $newSingle.data('url'));
      }
    };
    putDownAll = function(e) {
      if (($('.single').length)) {
        e.preventDefault();
      }
      closeFrame();
      return $('.single').each(function(i, single) {
        return setTimeout(function() {
          var slug;
          slug = $(single).attr('data-slug');
          return putDown(slug, true);
        }, i * 10);
      });
    };
    resizeFolder = function() {
      return $('.single.folder').each(function(i, single) {
        var $leftSect, $rightSect, $single, fontFactor, leftWidth, rightWidth, windowWidth;
        $single = $(single);
        $leftSect = $single.find('section.left');
        $rightSect = $single.find('section.right');
        windowWidth = $window.innerWidth();
        leftWidth = $leftSect.innerWidth();
        rightWidth = windowWidth - leftWidth;
        $rightSect.css({
          width: rightWidth
        });
        fontFactor = windowWidth * 2 * 19;
        return $single.find('section').each(function(i, sect) {
          var $inner, $sect, fontSize, sectWidth;
          $sect = $(sect);
          $inner = $sect.find('.inner');
          sectWidth = $sect.innerWidth();
          fontSize = sectWidth / windowWidth * 2 * 19;
          if (fontSize <= 25 && fontSize >= 9) {
            return $sect.find('.block').css({
              fontSize: fontSize + 'px'
            });
          }
        });
      });
    };
    makeResizable = function(single) {
      var $left, maxWidth, minWidth;
      $left = $(single).find('section.left');
      $(single).addClass('left');
      minWidth = $window.innerWidth() / 5;
      maxWidth = $window.innerWidth() - minWidth;
      return $left.resizable({
        handles: 'e',
        minWidth: minWidth,
        maxWidth: maxWidth,
        create: function(e, ui) {
          return $(e.target).addClass('resizable');
        },
        resize: function(e, ui) {
          return resizeFolder();
        },
        start: function(e, ui) {
          return $left.find('.video').addClass('noCursor');
        },
        stop: function(e, ui) {
          return $left.find('.video').removeClass('noCursor');
        }
      });
    };
    toggleFolder = function() {
      var $section, $single;
      $section = $(this);
      $single = $section.parents('.single');
      if (!checkSize('phone')) {
        return;
      }
      if ($single.is('.left')) {
        return $single.removeClass('left').addClass('right');
      } else if ($single.is('.right')) {
        return $single.removeClass('right').addClass('left');
      }
    };
    lookAt = function() {
      var $collected, $item, self, slug;
      self = this;
      if ($grid.is('.dragging') || $collection.is('.sorting')) {
        return;
      }
      slug = $(self).data('slug');
      $item = $('#grid .item[data-slug="' + slug + '"]');
      $collected = $('#collection .item[data-slug="' + slug + '"]');
      $collected.addClass('looking');
      return $item.addClass('looking');
    };
    lookAway = function() {
      var $collected, $item, self, slug;
      self = this;
      slug = $(self).data('slug');
      $item = $('#grid .item[data-slug="' + slug + '"]');
      $collected = $('#collection .item[data-slug="' + slug + '"]');
      $collected.removeClass('looking');
      return $item.removeClass('looking');
    };
    shiftAndRotate = function(item, e) {
      var $item, index, rotate, shift, shiftX, shiftY, winHeight, winWidth, x, y;
      $item = $(item);
      if ($item.is('.helper')) {
        return;
      }
      shift = $item.attr('data-shift');
      index = $item.attr('data-index');
      rotate = $item.attr('data-rotate');
      if (shift === 0 || !shift) {
        shift = 0.5;
      }
      winWidth = $(window).innerWidth();
      winHeight = $(window).innerHeight();
      if (e) {
        x = e.clientX;
        y = e.clientY;
      } else {
        x = winWidth / 2;
        y = winHeight / 2;
      }
      shiftX = -x / winWidth * shift;
      shiftY = -y / winHeight * shift;
      if (!rotate) {
        rotate = 0;
      }
      return $item.css({
        x: shiftX,
        y: shiftY,
        rotate3d: '0,0,1,' + rotate + 'deg'
      });
    };
    clickLink = function(e) {
      var $item, parsed, slug, url;
      e.preventDefault();
      url = this.href;
      parsed = url.split('/');
      slug = parsed[parsed.length - 1];
      $item = $grid.find('.item[data-slug="' + slug + '"]');
      if ($item) {
        return pickUp($item, true, true);
      }
    };
    browserNav = function(e) {
      var $item, action, slug, state;
      state = history.state;
      if (!$grid) {
        return;
      }
      if (state) {
        action = state.action;
        slug = state.slug;
        if (action === 'up') {
          $item = $grid.find('.item[data-slug="' + slug + '"]');
          return pickUp($item, false, false);
        } else if (action === 'down') {
          return putDown(slug, false, false);
        }
      } else {
        return putDownAll(e);
      }
    };
    closeSingle = function(e) {
      var slug;
      e.preventDefault();
      slug = $(e.target).parents('.single').attr('data-slug');
      return putDown(slug, true);
    };
    collectSingle = function(e) {
      var slug;
      slug = $(e.target).parents('.single').attr('data-slug');
      if ($(this).is('.add')) {
        collect(slug);
        $collection.find('[data-slug="' + slug + '"]').addClass('selected');
        $(this).removeClass('add');
        return $(this).addClass('remove');
      } else {
        $(this).removeClass('remove');
        $(this).addClass('add');
        return uncollect(slug);
      }
    };
    loadCollection = function() {
      var collection, collections, story;
      story = $table.data('story');
      collections = localStorage.getItem('mapping-the-spirit');
      if (!collections) {
        return;
      }
      collections = JSON.parse(collections);
      if (story) {
        collection = collections[story];
        return insertCollection(collection, story);
      } else {
        return $.each(collections, function(story, collection) {
          return insertCollection(collection, story);
        });
      }
    };
    insertCollection = function(collection, story) {
      return $.each(collection, function(i, slug) {
        var $item;
        $item = $table.find('[data-slug="' + slug + '"]');
        if ($item.length) {
          return collect(slug);
        } else {
          return createCollectionItem(slug, story);
        }
      });
    };
    createCollectionItem = function(item, story) {
      var inFooter, url;
      inFooter = !$body.is('.collection');
      url = '/api?item=' + item + '&story=' + story + '&footer=' + inFooter;
      if (window.location.href.indexOf('secret') > 1) {
        url = '/secret' + url;
      }
      $.ajax({
        url: url,
        dataType: 'html',
        error: function(jqXHR, status, err) {
          return console.log(jqXHR, status, err);
        },
        success: function(item, status, jqXHR) {
          if (!item) {
            return;
          }
          item = JSON.parse(item);
          return addToCollection(item, story, inFooter);
        }
      });
      if ($body.is('.aid')) {
        return $('.item[data-slug="' + item + '"]').addClass('collected');
      }
    };
    addToCollection = function(item, story, inFooter) {
      var $item, $itemInner, rotate, shift;
      $item = $('<a></a>');
      $item.addClass('click item collected');
      $item.addClass(item.type + ' ' + item.display + ' shift rotate');
      $item.attr('href', item.url);
      $item.attr('data-story', story);
      $item.attr('data-type', item.type);
      $item.attr('data-url', item.url);
      $item.attr('data-slug', item.slug);
      rotate = ((Math.random() * 1) - 25) / 100;
      shift = ((Math.random() * -100) - 200) / 100;
      $item.data('rotate', rotate);
      $item.data('shift', shift);
      if (item.display === 'text') {
        $itemInner = $('<div class="inner"><div class="text">' + item.content + '</div><div class="shadow"></div></div>');
        $itemInner.css('color', item.color);
      } else {
        $itemInner = $('<div class="inner"><div class="image"><img class="load" src="' + item.content + '"/></div></div>');
        if (item.bw === 'true') {
          $itemInner.find('.image').addClass('bw').css('background', item.color);
        }
      }
      $item.append($itemInner);
      if (inFooter) {
        $('#collection .items').append($item);
        $collection.removeClass('empty');
      } else {
        $grid.append($item);
        $grid.isotope('appended', $item);
        $grid.isotope('layout');
      }
      $item.imagesLoaded(function() {
        if (inFooter) {
          return resizeCollection();
        }
      });
      return loadImages();
    };
    saveCollection = function() {
      var $collectedItems, cleared, collections;
      $collectedItems = $collection.find('.item');
      collections = localStorage.getItem('mapping-the-spirit');
      if (collections) {
        collections = JSON.parse(collections);
      } else {
        collections = {};
      }
      cleared = [];
      $collectedItems.each(function(i, item) {
        var slug, story;
        slug = $(item).data('slug');
        story = $(item).attr('data-story');
        if ($.inArray(story, cleared) < 0) {
          collections[story] = [];
          cleared.push(story);
        }
        if ($.inArray(slug, collections[story]) < 0) {
          return collections[story].push(slug);
        }
      });
      collections = JSON.stringify(collections);
      localStorage.setItem('mapping-the-spirit', collections);
      return resizeCollection();
    };
    removeCollectedItem = function(story, item) {
      var collections, index;
      collections = localStorage.getItem('mapping-the-spirit');
      if (collections) {
        collections = JSON.parse(collections);
      } else {
        return;
      }
      index = $.inArray(item, collections[story]);
      if (index >= 0) {
        delete collections[story][index];
        collections = JSON.stringify(collections);
        return localStorage.setItem('mapping-the-spirit', collections);
      }
    };
    browseCollection = function(e) {
      var colWidth, mouse, mouseShift, offset, winWidth, x;
      if ($collection.is('.over') || $collection.is('.sorting')) {
        return;
      }
      mouse = e.clientX;
      winWidth = $window.width();
      colWidth = $collectionItems.width();
      if (winWidth > colWidth) {
        return;
      }
      mouse = event.pageX;
      mouseShift = colWidth * ((winWidth / 2 - mouse) / winWidth) * 1.1;
      offset = $(window).width() / 2;
      x = -colWidth / 2 + offset + mouseShift + mouse - winWidth / 2;
      if (x > 0) {
        x = 0;
      }
      return $collectionItems.css({
        x: x + 'px'
      });
    };
    resizeCollection = function() {
      var width, winWidth;
      width = 0;
      winWidth = $window.innerWidth();
      $collection.find('.item').each(function(i, item) {
        return width += $(item).outerWidth();
      });
      if (width < winWidth) {
        width += 10;
      }
      $collectionItems.css({
        width: width
      });
      if (width < winWidth) {
        return $collectionItems.css({
          x: 0
        });
      }
    };
    zoomImage = function() {
      var $bar, $block, $image, $text, $tools, img, url;
      $image = $(this);
      $block = $image.parents('.block');
      $text = $block.find('.text-wrap').clone();
      url = $image.attr('data-full');
      if (!url) {
        url = $image.attr('src');
      }
      $frame = $('<div id="frame" class="block image"><div id="frame-inner" class="has-loader"><div class="window loader"></div></div></div>');
      $tools = $('<div class="tools"><div class="expand"/><div class="out"/><div class="in"/><div class="close"/></div>');
      $bar = $('<div id="frame-bar"></div>');
      $bar.prepend($tools);
      $bar.append($text);
      if (!$text.find('.caption') || !$text.find('.caption').text().length) {
        $bar.addClass('noCaption');
      }
      $body.append($frame).append($bar);
      setTimeout(function() {
        $frame.addClass('show');
        return $bar.addClass('show');
      });
      img = new Image();
      img.src = url;
      return img.onload = function() {
        var bounds, height, imgHeight, imgWidth, northEast, southWest, width;
        imgWidth = img.naturalWidth;
        imgHeight = img.naturalHeight;
        height = $frame.innerHeight();
        width = (height / imgHeight) * imgWidth;
        window.frame = L.map('frame-inner', {
          minZoom: 2,
          maxZoom: 4,
          zoom: 1,
          center: [0, 0]
        });
        ({
          zoomControl: false,
          crs: L.CRS.Simple
        });
        southWest = frame.unproject([0, height], frame.getMaxZoom() - 1);
        northEast = frame.unproject([width, 0], frame.getMaxZoom() - 1);
        bounds = new L.LatLngBounds(southWest, northEast);
        L.imageOverlay(url, bounds).addTo(frame);
        frame.fitBounds(bounds);
        frame.setMaxBounds(bounds);
        return setTimeout(function() {
          return $frame.addClass('loaded');
        });
      };
    };
    frameTool = function() {
      var $frameBar;
      if ($(this).is('.out')) {
        return frame.zoomOut();
      } else if ($(this).is('.in')) {
        return frame.zoomIn();
      } else if ($(this).is('.close')) {
        return closeFrame();
      } else if ($(this).is('.expand')) {
        $frameBar = $('#frame-bar');
        $frameBar.toggleClass('toggled');
        return resizeFrameBar(this);
      }
    };
    closeFrame = function() {
      var $frameBar;
      $frameBar = $('#frame-bar');
      $frame.on(transEnd, function() {
        $frame.remove();
        $frameBar.remove();
        return $frame.off(transEnd);
      });
      $frame.removeClass('show');
      return $frameBar.removeClass('show');
    };
    resizeFrameBar = function(button) {
      var $frameBar, height;
      $frameBar = $('#frame-bar');
      if ($frameBar.is('.toggled')) {
        height = $frameBar.find('.text-wrap').innerHeight();
      } else {
        height = $frameBar.find('.meta').innerHeight();
      }
      return $frameBar.css({
        height: height
      });
    };
    hoverRow = function() {
      var $row;
      $row = $(this).parents('.row');
      return $row.addClass('hover');
    };
    unhoverRow = function() {
      var $row;
      $row = $(this).parents('.row');
      return $row.removeClass('hover');
    };
    goBack = function(e) {
      e.preventDefault();
      return window.history.back();
    };
    checkSize = function(check) {
      var size;
      size = $body.css('content').replace(/\"/g, '');
      if (!check) {
        return size;
      } else if (size === check) {
        return true;
      } else {
        return false;
      }
    };
    noHover = function() {
      var j, len, ref, results, ri, si, styleSheet, touch;
      touch = indexOf.call(document.documentElement, 'ontouchstart') >= 0 || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0);
      if (!touch) {
        return;
        try {

        } catch (undefined) {}
        ref = document.styleSheets;
        results = [];
        for (j = 0, len = ref.length; j < len; j++) {
          si = ref[j];
          styleSheet = document.styleSheets[si];
          if (styleSheet.rules) {
            break;
          }
          ri = styleSheet.rules.length - 1;
          results.push((function() {
            var results1;
            results1 = [];
            while (ri >= 0) {
              if (styleSheet.rules[ri].selectorText) {
                break;
              }
              if (styleSheet.rules[ri].selectorText.match(':hover')) {
                styleSheet.deleteRule(ri);
              }
              results1.push(ri--);
            }
            return results1;
          })());
        }
        return results;
      }
    };
    return init();
  });

}).call(this);
