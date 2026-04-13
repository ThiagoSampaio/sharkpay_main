 before and after the visible area to cache items
  /// that are about to become visible when the user scrolls.
  ///
  /// Items that fall in this cache area are laid out even though they are not
  /// (yet) visible on screen. The [cacheExtent] describes how many pixels
  /// the cache area extends before the leading edge and after the trailing edge
  /// of the viewport.
  ///
  /// The total extent, which the viewport will try to cover with children, is
  /// [cacheExtent] before the leading edge + extent of the main axis +
  /// [cacheExtent] after the trailing edge.
  ///
  /// The cache area is also used to implement implicit accessibility scrolling
  /// on iOS: When the accessibility focus moves from an item in the visible
  /// viewport to an invisible item in the cache area, the framework will bring
  /// that item into view with an (implicit) scroll action.
  /// {@endtemplate}
  ///
  /// The getter can never return null, but the field is nullable
  /// because the setter can be set to null to reset the value to
  /// [RenderAbstractViewport.defaultCacheExtent] (in which case
  /// [cacheExtentStyle] must be [CacheExtentStyle.pixel]).
  ///
  /// See also:
  ///
  ///  * [cacheExtentStyle], which controls the units of the [cacheExtent].
  double? get cacheExtent => _cacheExtent;
  double _cacheExtent;
  set cacheExtent(double? value) {
    value ??= RenderAbstractViewport.defaultCacheExtent;
    if (value == _cacheExtent) {
      return;
    }
    _cacheExtent = value;
    markNeedsLayout();
  }

  /// This value is set during layout based on the [CacheExtentStyle].
  ///
  /// When the style is [CacheExtentStyle.viewport], it is the main axis extent
  /// of the viewport multiplied by the requested cache extent, which is still
  /// expressed in pixels.
  double? _calculatedCacheExtent;

  /// {@t