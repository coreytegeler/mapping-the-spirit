$ ->
	$body = $('body')
	$main = $('.main')
	$grid = $('.grid')
	init = () ->

		$body.on 'click', '.item', () ->
			pickUp(this)
		$body.on 'mouseover', '.item', () ->
			lookAt(this)
		$body.on 'mouseleave', '.item', () ->
			lookAway(this)

		$grid.imagesLoaded () ->	
			$grid.masonry({
				itemSelector: '.item',
				columnWidth: '.sizer',
				gutter: '.gutter',
				fitWidth: true,
				transitionDuration: 0
			})

		pickUp = (self) ->
			index = $(self).data('index')
			$item = $('.grid .item[data-index="'+index+'"]')
			$figcaption = $('aside figcaption[data-index="'+index+'"]')
			$figcaption.addClass('selected')
			$main.addClass('hide')
			# setTimeout( ->
			$body.addClass('reading')
			# 600)

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