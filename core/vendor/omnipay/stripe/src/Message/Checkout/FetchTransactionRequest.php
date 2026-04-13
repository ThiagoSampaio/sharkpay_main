ta is! StackParentData) {
      child.parentData = StackParentData();
    }
  }

  Alignment get _resolvedAlignment => _resolvedAlignmentCache ??= alignment.resolve(textDirection);
  Alignment? _resolvedAlignmentCache;

  void _markNeedResolution() {
    _resolvedAlignmentCache = null;
    markNeedsLayout();
  }

  /// How to align the non-positioned or partially-positioned children in the
  /// stack.
  ///
  /// The non-positioned children are placed relative to each other such that
  /// the points determined by [alignment] are co-located. For example, if the
  /// [alignment] is [Alignment.topLeft], then the top left corner of
  /// each non-positioned child will be located at the same global coordinate.
  ///
  /// Partially-positioned children, those that do not specify an alignment in a
  /// particular axis (e.g. that have neither `top` nor `bottom` set), use the
  /// alignment to determine how they should be positioned in that
  /// under-specified axis.
  ///
  /// If this is set to an [AlignmentDirectional] object, then [textDirection]
  /// must not be null.
  AlignmentGeometry get alignment => _alignment;
  AlignmentGeometry _alignment;
  set alignment(AlignmentGeometry value) {
    if (_alignment 