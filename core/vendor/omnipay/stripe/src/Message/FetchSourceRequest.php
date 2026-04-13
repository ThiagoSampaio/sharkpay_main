Origin: -_calculatedCacheExtent!,
    );
  }

  @override
  bool get hasVisualOverflow => _hasVisualOverflow;

  @override
  void updateOutOfBandData(GrowthDirection growthDirection, SliverGeometry childLayoutGeometry) {
    assert(growthDirection == GrowthDirection.forward);
    _maxScrollExtent += childLayoutGeometry.scrollExtent;
    if (childLayoutGeometry.hasVisualOverflow) {
      _hasVisualOverflow = true;
    }
    _shrinkWrapExtent += childLayoutGeometry.maxPaintExtent;
  }

  @override
  void updateChildLayoutOffset(
    RenderSliver child,
    double layoutOffset,
    GrowthDirection growthDirection,
  ) {
    assert(growthDirection == GrowthDirection.forward);
    final SliverLogicalParentData childParentData = child.parentData! as SliverLogicalParentData;
    childParentData.layoutOffset = layoutOffset;
  }

  @override
  Offset paintOffsetOf(RenderSliver child) {
    final SliverLogicalParentData childParentData = child.parentData! as SliverLogica