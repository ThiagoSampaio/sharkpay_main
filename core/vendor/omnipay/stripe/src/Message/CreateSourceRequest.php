plying the returned offset. If `alignment` is 0.0, the child must
  /// be positioned as close to the leading edge of the viewport as possible. If
  /// `alignment` is 1.0, the child must be positioned as close to the trailing
  /// edge of the viewport as possible. If `alignment` is 0.5, the child must be
  /// positioned as close to the center of the viewport as possible.
  ///
  /// The `target` might not be a direct child of this viewport but it must be a
  /// descendant of the viewport. Other viewports in between this viewport and
  /// the `target` will not be adjusted.
  ///
  /// This method assumes that the content of the viewport moves linearly, i.e.
  /// when the offset of the viewport is changed by x then `target` also moves
  /// by x within the viewport.
  ///
  /// The optional [Axis] is used by
  /// [RenderTwoDimensionalViewport.getOffsetToReveal] to
  /// determine which of the two axes to compute an offset for. One dimensional
  /// subclasses like [RenderViewportBase] and [RenderListWheelViewport]
  /// will ignore the `axis` value if provided, since there is only one [Axis].
  ///
  /// If the `axis` is omitted when called on [RenderTwoDimensionalViewport],
  /// the [RenderTwoDimensionalViewport.mainAxis] is used. To reveal an object
  /// properly in both axes, this method should be called for each [Axis] as the
  /// returned [RevealedOffset.offset] only represents the offset of one of the
  /// the two [ScrollPosition]s.
  ///
  /// See also:
  ///
  ///  * [RevealedOffset], which describes the return value of this method.
  RevealedOffset getOffsetToReveal(RenderObject target, double alignment, {Rect? rect, Axis? axis});

  /// The default value for the cache extent of the viewport.
  ///
  /// This default assumes [CacheExtentStyle.pixel].
  ///
  /// See also:
  ///
  ///  * [RenderViewportBase.cacheExtent] for a definition of the cache extent.
  static const double defaultCacheExtent = 250.0;
}

/// Return value for [RenderAbstractViewport.getOffsetToReveal].
///
/// It indicates the [offset] required to reveal an element in a viewport and
/// the [rect] position said element would have in the viewport at that
/// [offset].
class RevealedOffset {
  /// Instantiates a return value for [RenderAbstractViewport.getOffsetToReveal].
  const RevealedOffset({required this.offset, required this.rect});

  /// Offset for the viewport to reveal a specific element in the viewport.
  ///
  /// See also:
  ///
  ///  * [RenderAbstractViewport.getOffsetToReveal], which calculates this
  ///    value for a specific element.
  final double offset;

  /// The [Rect] in the outer coordinate system of the viewport at which the
  /// to-be-revealed element would be located if the viewport's offset is set
  /// to [offset].
  ///
  /