$ ->
	$window = $(window)
	$body = $('body')
	$main = $('.main')
	$grid = $('.grid')
	$subtitle = $('header .subtitle')
	$table = $('#table')
	$single = $('#single')
	$collection = $('#collection')
	transEnd = 'transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd'

	init = () ->
		dragAndDrop()
		$body.on 'mousewheel', '.horzScroll', (event) ->
			horzScroll(this, event)
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

	resizeGrid = () ->
		gutter = $grid.find('.gutter').innerWidth()
		$grid.isotope
			layoutMode: 'masonryHorizontal',
			itemSelector: '.item',
			isAnimated: false,
			percentPosition: false,
			gutter: gutter,
			masonryHorizontal: {
				rowHeight: '.sizer',
				gutter: gutter,
				percentPosition: true,
				isAnimated: false
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

	horzScroll = (self, event) ->
		delta = event.deltaY
		if(delta != 0)
			event.preventDefault()
			self.scrollLeft -= delta

	tableScroll = (self) ->
		scrollLeft = $(self).scrollLeft()
		$bigTitle = $('#title')
		# opacity = 1 - (scrollLeft/1000)
		# if(opacity > .05)
		# 	$bigTitle.css
		# 		opacity: opacity
		titleRight = scrollLeft - $subtitle.innerWidth()
		if(titleRight >= 0)
			titleRight = 0
		$subtitle.css
			right: titleRight+'px'

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
			drag: (event, ui) ->
				$helper = $(ui.helper)
				itemTop = ui.offset.top
				collectionTop = $collection.find('.items').offset().top
				if(itemTop >= collectionTop - 1)
					$helper.addClass('over')
				else
					$helper.removeClass('over')
			stop: (event, ui) ->
				$helper = $(ui.helper)
				# $(ui.helper).removeClass('looking')

		$collection.droppable
			accept: '.item',
			drop: (event, ui) ->
				$item = $(ui.draggable[0]).clone()
				$(this).removeClass('over')
				holdOn($item)
			over: (event, ui) ->
				$collection.addClass('over')
			out: (event, ui) ->
				$collection.removeClass('over')

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
		index = $(self).data('index')
		type = $(self).data('type')
		$item = $(self)
		itemSlug = $item.data('slug')
		storySlug = $item.data('story')
		$figcaption = $('aside figcaption[data-index="'+index+'"]')
		$figcaption.addClass('selected')
		$body.addClass('looking')
		$single.addClass('show')
		url = '/stories/' + storySlug + '/' + itemSlug
		$.ajax
			url: url
			dataType: 'html'
			error: (jqXHR, status, err) ->
				console.log(jqXHR)
				console.log(status)
				console.error(err)
			success: (response, status, jqXHR) ->
				history.pushState('data', '', url);
				$subtitle.transition({right: 0}, 500, 'easeInOutCubic')
				$single.addClass(type).attr('data-item', itemSlug)
				if($single.html())
					$single.on transEnd, () ->
						$single.off(transEnd)
						createSingle(response)
					$single.addClass('replacing')
				else
					createSingle(response)

	createSingle = (html) ->
		$single.html(html)
		$single.on transEnd, () ->
			$single.off(transEnd)
			loadSingle()
			$single.removeClass('replacing')
		setTimeout (-> $single.addClass('loaded')), 100

	loadSingle = () ->
		$subtitle.css({right:0})
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
		$figcaption = $('aside figcaption.selected').removeClass('selected')
		$body.removeClass('looking folder')
		$single.removeClass('loaded')
		scrollLeft = $table.scrollLeft()
		subtitleWidth = $subtitle.innerWidth()
		subtitleRight = scrollLeft - subtitleWidth
		if(subtitleRight >= 0)
			subtitleRight = 0
		$subtitle.transition({right: subtitleRight}, 500, 'easeInOutQuint')
		$single.on transEnd, () ->
			$single.off(transEnd)
			$single.attr('class', '')
			$single.html('')

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
		index = $(self).data('index')
		$item = $('.grid .item[data-index="'+index+'"]')
		$figcaption = $('aside figcaption[data-index="'+index+'"]')
		$figcaption.addClass('highlight')
		$item.addClass('looking')

	lookAway = (self) ->
		index = $(self).data('index')
		$item = $('.grid .item[data-index="'+index+'"]')
		$figcaption = $('aside figcaption[data-index="'+index+'"]')
		$figcaption.removeClass('highlight')
		$item.removeClass('looking')

	init()