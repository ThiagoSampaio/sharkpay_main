hDirection.sample}
  RenderSliver? get center => _center;
  RenderSliver? _center;
  set center(RenderSliver? value) {
    if (value == _center) {
      return;
    }
    _center = value;
    markNeedsLayout();
  }

  @override
  bool get sizedByParent => true;

  @override
  @protected
  Size computeDryLayout(covariant BoxConstraints constraints) {
    assert(debugCheckHasBoundedAxis(axis, constraints));
    return constraints.biggest;
  }

  static const int _maxLayoutCyclesPerChild = 10;

  // Out-of-band data computed during layout.
  late double _minScrollExtent;
  late double _maxScrollExtent;
  bool _hasVisualOverflow = false;

  @override
  void performLayout() {
    // Ignore the return value of applyViewportDimension because we are
    // doing a layout regardless.
    switch (axis) {
      case Axis.vertical:
        offset.applyViewportDimension(size.height);
      case Axis.horizontal:
        offset.applyViewportDimension(size.width);
    }

    if (center == null) {
      assert(firstChild ==