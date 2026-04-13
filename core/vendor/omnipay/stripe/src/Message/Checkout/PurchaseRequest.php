IntrinsicWidth(height),
    );
  }

  @override
  double computeMinIntrinsicHeight(double width) {
    return getIntrinsicDimension(
      firstChild,
      (RenderBox child) => child.getMinIntrinsicHeight(width),
    );
  }

  @override
  double computeMaxIntrinsicHeight(double width) {
    return getIntrinsicDimension(
      firstChild,
      (RenderBox child) => child.getMaxIntrinsicHeight(width),
    );
  }

  @override
  double? computeDistanceToActualBaseline(TextBaseline baseline) {
    return defaultComputeDistanceToHighestActualBaseline(baseline);
  }

  /// Lays out the positioned `child` according to `alignment` within a Stack of `size`.
  ///
  /// Returns true when the child has visual overflow.
  static bool layoutPositionedChild(
    RenderBox child,
    StackParentData childParentData,
    Size size,
    Alignment alignment,
  ) {
    assert(childParentData.isPositioned);
    assert(child.parentData == childParentData);
    final BoxConstraints childConstraints = childParentData.positionedChildConstraints(size);
    child.layout(childConstraints, parentUsesSize: true);

    final double x = switch (childParentData) {
      StackParentData(:final double left?) => left,
      StackParentData(:final double right?) => size.width - right - child.size.width,
      StackParentData() => alignment.alongOffset(size - child.size as Offset).dx,
    };

    final double y = switch (childParentData) {
      StackParentData(:final double top?) => top,
      StackParentData(:final double bottom?) => size.height - bottom - child.size.height,
      StackParentData() => alignment.alongOffset(size - child.size as Offset).dy,
    };

    childParentData.offset = Offset(x, y);
    return x < 0.0 ||
        x + child.size.width > size.width ||
        y < 0.0 ||
        y + child.size.height > size.height;
  }

  static double? _baselineForChild(
    RenderBox child,
    Size stackSize,
    BoxConstraints nonPositionedChildConstraints,
    Alignment alignment,
    TextBaseline baseline,
  ) {
    final StackParentData childParentData = child.parentData! as StackParentData;
    final BoxConstraints childConstraints =
        childParentData.isPositioned
            ? childParentData.positionedChildConstraints(stackSize)
            : nonPositionedChildConstraints;
    final double? baselineOffset = child.getDryBaseline(childConstraints, baseline);
    if (baselineOffset == null) {
      return null;
    }
    final double y = switch (childParentData) {
      StackParentData(:final double top?) => top,
      StackParentData(:final double bottom?) =>
        stackSize.height - bottom - child.getDryLayout(childConstraints).height,
      StackParentData() =>
        alignment.alongOffset(stackSize - child.getDryLayout(childConstraints) as Offset).dy,
    };
    return baselineOffset + y;
  }

  @override
  double? computeDryBaseline(BoxConstraints constraints, TextBaseline baseline) {
    final BoxConstraints nonPositionedChildConstraints = switch (fit) {
      StackFit.loose => constraints.loosen(),
      StackFit.expand => BoxConstraints.tight(constraints.biggest),
      StackFit.passthrough => constraints,
    };

    final Alignment alignment = _resolvedAlignment;
    final Size size = getDryLayout(constraints);

    BaselineOffset baselineOffset = BaselineOffset.noBaseline;
    for (RenderBox? child = firstChild; child != null; child = childAfter(child)) {