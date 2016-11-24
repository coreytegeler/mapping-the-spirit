$ ->
	$window = $(window)
	$body = $('body')
	$main = $('main')
	$header = $('header')
	$grid = $('.grid')
	$pageTitle = $header.find('.pageTitle span')
	$secondary = $header.find('.secondary')
	$table = $('#table')
	$single = $('#single')
	$collection = $('#collection')
	transEnd = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd'

	init = () ->
		dragAndDrop()
		$body.on 'mousewheel', '.horzScroll', (event) ->
			horzScroll(this, event)
		$body.scroll (event) ->
			vertScroll(this, event)
		$table.scroll () ->
			tableScroll(this)
		$body.on 'click', '.item.click', () ->
			pickUp(this)
		$body.on 'mouseover', '.item.click', () ->
			lookAt(this)
		$body.on 'mouseleave', '.item.click', () ->
			lookAway(this)
		$body.on 'click', 'header .close', () ->
			putDown()

		if($body.is('.looking'))
			loadSingle()

		$grid.imagesLoaded () ->
			resizeGrid()

		$(window).resize () ->
			resizeSects()
			resizeGrid()
			vertScroll()

	resizeGrid = () ->
		gutter = $grid.find('.gutter').innerWidth()
		$grid.isotope
			layoutMode: 'masonryHorizontal',
			itemSelector: '.item',
			percentPosition: false,
			gutter: gutter,
			transitionDuration: 0
			masonryHorizontal: {
				rowHeight: '.sizer',
				gutter: gutter,
				percentPosition: true,
				transitionDuration: 0
			},
			animationOptions: {
				duration: 0
			}
		$grid.find('.item').each () ->
			$item = $(this)
			if($item.is('.large'))
				height = $table.innerHeight() - gutter*2
			else
				height = $table.innerHeight()/2 - gutter*1.5
			$item.css
				height: height
			$item.find('img').css
				height: height
		$grid.isotope()
		$grid.addClass('loaded')

	vertScroll = (self, event) ->
		vertScrollTop = $main.scrollTop()
		$section = $header.parents('section')
		if !$section.length
			return
		sectionTop = $section.offset().top
		if(sectionTop <= 0)
			$header.addClass('fixed')
			paddingTop = $header.innerHeight()
		else
			$header.removeClass('fixed')
			paddingTop = 0
		$section.css
			paddingTop: paddingTop

	horzScroll = (self, event) ->
		delta = event.deltaY
		if(delta != 0)
			event.preventDefault()
			self.scrollLeft -= delta

	tableScroll = (self) ->
		scrollLeft = $(self).scrollLeft()
		$bigTitle = $('#title')
		# titleRight = $pageTitle.innerWidth() - scrollLeft
		# if(titleRight <= 0)
		# 	titleRight = 0
		# $pageTitle.css
		# 	x: titleRight+'px'

	dragAndDrop = () ->
		gutter = $grid.find('.gutter').innerWidth()
		$grid.find('.item').draggable
			containment: 'body',
			helper: 'clone',
			snap: '#collection',
			snapMode: 'inner',
			snapTolerance: 0,
			appendTo: 'body',
			scroll: false,
			cursorAt:
				left: 0,
				top: 0
			start: (event, ui) ->
				$helper = $(ui.helper)
				$grid.addClass('dragging')
			drag: (event, ui) ->
				$helper = $(ui.helper)
				itemTop = ui.offset.top
				collectionTop = $collection.find('.items').offset().top
				if(itemTop >= collectionTop - 1)
					$helper.addClass('over')
				else
					$helper.removeClass('over')
			stop: (event, ui) ->
				$grid.removeClass('dragging')

		$collection.droppable
			accept: '.item.droppable',
			drop: (event, ui) ->
				$(this).removeClass('over')
				$item = $(ui.draggable[0]).clone()
				$item.removeClass('droppable')
				holdOn($item)
			over: (event, ui) ->
				$collection.addClass('over')
			out: (event, ui) ->
				$collection.removeClass('over')

		$collection.find('.items').sortable
			items: '> .item',
			containment: 'body',
			helper: 'clone',
			axis: 'x',
			snap: '#collection .items',
			snapMode: 'inner',
			snapTolerance: 0,
			scroll: false,
			placeholder: 'placeholder',
			forcePlaceholderSize: true,
			cursorAt:
				left: 0,
				top: 0
			start: (event, ui) ->
				$collection.addClass('sorting')
			stop: (event, ui) ->
				$collection.removeClass('sorting')


	holdOn = (item) ->
		$item = $(item)
		$item.attr('style', '')
		$item.find('img').attr('style', '')
		slug = $item.data('slug')
		if($collection.find('[data-slug="'+slug+'"]').length)
			return
		$collection.removeClass('empty')
		$collection.find('.items').append($item)

	pickUp = (self) ->
		$item = $(self)
		index = $item.attr('data-index')
		type = $item.attr('data-type')
		slug = $item.attr('data-slug')
		url = $item.attr('data-url')
		storySlug = $item.attr('data-story')
		$collected = $('#collection .item[data-index="'+index+'"]')
		$collected.addClass('selected')
		$body.addClass('looking')
		$single.addClass('open')
		setTimeout () ->
			$single.addClass('show')
		, 10
		$.ajax
			url: url
			dataType: 'html'
			error: (jqXHR, status, err) ->
				console.log(jqXHR)
				console.log(status)
				console.error(err)
			success: (response, status, jqXHR) ->
				history.pushState('data', '', url);
				# $pageTitle.transition({x: 0}, 500, 'easeInOutCubic')
				$single.addClass(type).attr('data-item', slug)
				if($single.html())
					$single.on transEnd, () ->
						$single.off(transEnd)
						createSingle(response)
					$single.addClass('replacing')
				else
					createSingle(response)

	createSingle = (html) ->
		$single.on transEnd, () ->
			$data = $($(html)[0])
			title = $data.data('title')
			slug = $data.data('slug')
			url = $data.data('url')
			$single
				.data('title', title)
				.data('slug', slug)
				.data('url', url)
			$header.find('.title.item')
			.addClass('show')
			.find('a')
				.html(title)
				.attr('href', url)
			$single.off(transEnd)
			$single.html(html)
			loadSingle()
			$single.removeClass('replacing')

	loadSingle = () ->
		# $pageTitle.css({x:0})
		$single.find('section img').eq(0).imagesLoaded () ->
			$single.addClass('loaded')
			imagesLoaded($single).on 'progress', (inst, image) ->
				$item = $(image.img).parents('.item')
				$item.addClass('loaded')
			$('section#left').resizable
				handles: 'e',
				resize: () ->
					resizeSects()

	putDown = () ->
		itemSlug = $single.attr('data-item')
		url = window.location.href.replace(itemSlug, '')
		history.replaceState({}, '', url);
		$collected = $('#collection .item.selected').removeClass('selected')
		$body.removeClass('looking folder')
		scrollLeft = $table.scrollLeft()
		# pageTitleWidth = $pageTitle.innerWidth()
		# pageTitleRight = pageTitleWidth - scrollLeft
		if(pageTitleRight <= 0)
			pageTitleRight = 0
		# $pageTitle.transition({x: pageTitleRight}, 500, 'easeInOutQuint')
		$single.on transEnd, () ->
			$single.off(transEnd)
			$single.removeClass('')
			$single.attr('class', '')
			$single.html('')
		$single.removeClass('show')

	scrolls = { left: { top: 0, height: 0 }, right: { top: 0, height: 0 } }
	resizeSects = () ->
		$leftSect = $single.find('section#left')
		$rightSect = $single.find('section#right')
		windowWidth = $window.innerWidth()
		leftWidth = $leftSect.innerWidth()
		rightWidth = windowWidth - leftWidth
		$rightSect.css({width:rightWidth})
		fontFactor = windowWidth*2*19
		$single.find('section').each (i, sect) ->
			$sect = $(sect)
			$inner = $sect.find('.inner')
			sectWidth = $sect.innerWidth()
			fontSize = sectWidth/windowWidth*2*19
			if(fontSize <= 25 && fontSize >= 9)
				$sect.find('.text').css({fontSize:fontSize+'px'})

	lookAt = (self) ->
		if($grid.is('.dragging') || $collection.is('.sorting'))
			return
		index = $(self).data('index')
		$item = $('.grid .item[data-index="'+index+'"]')
		$collected = $('#collection .item[data-index="'+index+'"]')
		$collected.addClass('looking')
		$item.addClass('looking')

	lookAway = (self) ->
		index = $(self).data('index')
		$item = $('.grid .item[data-index="'+index+'"]')
		$collected = $('#collection .item[data-index="'+index+'"]')
		$collected.removeClass('looking')
		$item.removeClass('looking')

	init()